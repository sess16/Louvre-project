<?php
/**
 * Created by PhpStorm.
 * Author: Selim Khaldi
 * Author URI: https://twitter.com/SelimKhaldi
 * Company: KHALSOMM Digital
 * Company URI: http://www.khalsomm.com
 * Date: 02/12/2017
 * Time: 11:15
 */

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Error\Card;

class OrderController extends Controller
{
    const MAXIMUM_TICKET = 1000;
    const MAXIMUM_TICKET_NUMBER_PER_DAY = 1000;
    /**
     * @return Response
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);

        //check form submission
        if ($request->isMethod('POST'))
        {
            //link $order with data typed in the form
            $form->handleRequest($request);
            //check data
            if ($form->isValid()){
                dump($form->getData());
                dump($form['order[customerEmail]']);
                //check for number of ticket left
                $ticketLeft = $this->ticketLeftOnDate($order->getVenueDate());
                $message = $order->checkOrderProcessing($ticketLeft);
                if ($message !== null){
                    $this->addFlash("warning", $message);
                    return $this->render('Default/create.html.twig',[
                        'order' => $form->createView()
                    ]);
                }
                //check for ticket type et time of the day
                $message = $order->checkDurationVisit();
                if ($message !== null)
                {
                    $this->addFlash("warning", $message);
                    return $this->render('Default/create.html.twig',[
                        'order' => $form->createView()
                    ]);
                }
                //we are now okay to process
                $em = $this->getDoctrine()->getManager();
                //create the order number
                $order->createOrderNumber();
                //check that the order number is unique
                while ($em->getRepository('App:Order')->findByOrderNumber($order->getOrderNumber())){
                    $order->createOrderNumber();
                }
                //relate each item to the order
                foreach ($order->getItems() as $item){
                    $order->addItem($item);
                    $em->persist($item);
                    //set the ticket
                    $item->setTicket(
                        $em->getRepository('App:Ticket')
                            ->getTicketByRateAndDuration($item->getTicketRate(), $order->getDuration())
                    );
                }
                $em->flush();
                #return $this->redirectToRoute('checkout_ticket',['id' => $order->getId()]);
            }

        }
        return $this->render('Default/create.html.twig',[
            'order' => $form->createView()
        ]);

    }

    /**
     * @Route("/checkout/{id}", name="checkout_ticket")
     */
    public function checkout(Order $order)
    {
        //check that the order has not been paid all ready(this is a security mesure)
        if ($order->isOrderPaid()){
            throw $this->createNotFoundException("Une erreur s'est produite.");
        }
        $em = $this->getDoctrine()->getManager();
        $lines = $em->getRepository('App:Item')->getItemsDataFromOrder($order);
        $total_amount = $em->getRepository('App:Item')->getTotalAmountOfOrder($order);
        $amount = $total_amount['total_price'];
        //stripe need the price in cents
        $stripe_amount = $amount * 100;
        return $this->render('Default/checkout.html.twig', [
            'order' => $order,
            'lines' => $lines,
            'stripe_amount' => $stripe_amount,
            'amount' => $amount
        ]);
    }

    /**
     * @Route("/paiement/{id}", name="pay_ticket")
     */
    public function pay(Order $order)
    {
        //check that the order has not been paid all ready(this is a security mesure)
        if ($order->isOrderPaid()){
            throw $this->createNotFoundException("Une erreur s'est produite.");
        }
        $em = $this->getDoctrine()->getManager();
        //retrieve the amount
        $total_amount = $em->getRepository('App:Item')->getTotalAmountOfOrder($order);
        $stripe_amount = $total_amount['total_price'] * 100;
        //secret key for the api
        Stripe::setApiKey("sk_test_pCJ8ZnBsCnvehQv23QNEWaPv");
        //recover the token created by checkout page
        $token = $_POST['stripeToken'];
        //create the charge to get paiement from user
        try {
            Charge::create([
                "amount" => $stripe_amount,
                "currency" => "eur",
                "description" => "Commande " . $order->getOrderNumber(),
                "source" => $token
            ]);
            //changing the order to paid
            $order->setOrderPaid(true);
            $em->flush();
            $this->addFlash("success","Votre paiement a bien été enregistré.");
            return $this->redirectToRoute('confirm_ticket', ['id' => $order->getId()]);
        }catch (Card $e){
            // Card was declined.
            $e_json = $e->getJsonBody();
            $message = "Une erreur s'est produite : <strong>";
            switch ($e_json['error']['code']){
                case 'invalid_number':
                    $message .= "le numéro de la carte n'est pas un numéro valide.";
                    break;
                case 'invalid_expiry_month':
                    $message .= "le mois d'expiration de la carte est incorrect.";
                    break;
                case 'invalid_expiry_year':
                    $message .= "l'année d'expiration de la carte est incorrecte.";
                    break;
                case 'invalid_cvc':
                    $message .= "le code de sécurité de la carte n'est pas valide.";
                    break;
                case 'incorrect_number':
                    $message .= "le number de la carte est incorrect.";
                    break;
                case 'expired_card':
                    $message .= "la carte a expiré.";
                    break;
                case 'incorrect_cvc':
                    $message .= "le code de sécurité de la carte est incorrect.";
                    break;
                case 'incorrect_zip':
                    $message .= "le code postal n'a pas été validé.";
                    break;
                case 'card_declined':
                    $message .= "la carte a été refusée.";
                    break;
                default:
                    $message .= "impossibilité de traiter votre carte.";
            }
            $message .= "</strong><br>Veuillez essayer à nouveau.";
            $this->addFlash("danger", $message);
            //redirect to paiement page
            return $this->redirectToRoute('checkout_ticket', ['id' => $order->getId()]);
        }
    }

    /**
     * @Route("/confirmation/{id}", name="confirm_ticket")
     */
    public function confirm(Order $order)
    {
        //check to see if email has been sent already
        if ($order->isEmailSent()){
            throw new \Exception("Erreur interne.");
        }
        $em = $this->getDoctrine()->getManager();
        //retrieve the amount
        $total_amount = $em->getRepository('App:Item')->getTotalAmountOfOrder($order);
        //retrieving the details of the order
        $lines = $em->getRepository('App:Item')->getItemsDataFromOrder($order);
        //creating message to send
        $message = (new \Swift_Message('Musée du Louvre : votre commande'))
            ->setFrom('tickets@lelouvre.fr')
            ->setTo($order->getCustomerEmail())
            ->setBody(
                $this->renderView('Mail/sendticket.html.twig', [
                    'order' => $order,
                    'lines' => $lines,
                    'total' => $total_amount['total_price']
                ]),
                'text/html'
            );
        $this->get('mailer')->send($message);
        //set emailSent flag to true
        $order->setEmailSent(true);
        $em->flush();

        return $this->render('Default/confirm.html.twig');

    }

    /**
     * @Route("/date/{date}", name="check_date", options={"expose"=true})
     */
    public function checkDate(\DateTime $date)
    {
        $ticketLeft = $this->ticketLeftOnDate($date);
        $response = new JsonResponse();
        return $response->setData(array('ticketLeft' => $ticketLeft ));
    }

    private function ticketLeftOnDate(\DateTime $date)
    {
        $em = $this->getDoctrine()->getManager();
        $tickets = $em->getRepository('App:Order')->getNumberTicketLeftForDate($date);
        $ticketLeft = ((self::MAXIMUM_TICKET_NUMBER_PER_DAY - $tickets['sold']) > 0 ) ? self::MAXIMUM_TICKET_NUMBER_PER_DAY - $tickets['sold'] : 0;
        return $ticketLeft;
    }



}