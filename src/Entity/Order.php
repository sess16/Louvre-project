<?php
/**
 * Created by PhpStorm.
 * Author: Selim Khaldi
 * Author URI: https://twitter.com/SelimKhaldi
 * Company: KHALSOMM Digital
 * Company URI: http://www.khalsomm.com
 * Date: 06/01/2018
 * Time: 17:51
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $orderDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Veuillez spécifier une date de visite.")
     * @Assert\Date(message="Date invalide.")
     */
    private $venueDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $orderNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Veuillez spécifier une adresse email.")
     * @Assert\Email(message="Veuillez vérifier votre email.")
     * @Assert\Length(max=100, maxMessage="100 caractères au plus.")
     */
    private $customerEmail;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $orderPaid;

    /**
     * @var \App\Entity\Duration
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Duration")
     * @ORM\JoinColumn(name="duration_id", referencedColumnName="id")
     */
    private $duration;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="order")
     * @Assert\Count(min=1,minMessage="Vous devez avoir au moins un ticket pour passer une commande.")
     * @Assert\Valid()
     */
    private $items;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $emailSent;

    /**
     * Order constructor.
     * Set default values for our order
     */
    public function __construct()
    {
        $this->orderPaid = false;
        $this->emailSent = false;
        $this->orderDate = new \DateTime();
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * @return \DateTime
     */
    public function getVenueDate()
    {
        return $this->venueDate;
    }

    /**
     * @param \DateTime $venueDate
     */
    public function setVenueDate($venueDate)
    {
        $this->venueDate = $venueDate;
    }

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @param string $customerEmail
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;
    }

    /**
     * @return bool
     */
    public function isOrderPaid()
    {
        return $this->orderPaid;
    }

    /**
     * @param bool $orderPaid
     */
    public function setOrderPaid($orderPaid)
    {
        $this->orderPaid = $orderPaid;
    }

    /**
     * @return bool
     */
    public function isEmailSent()
    {
        return $this->emailSent;
    }

    /**
     * @param bool $emailSent
     */
    public function setEmailSent($emailSent)
    {
        $this->emailSent = $emailSent;
    }

    /**
     * @return Duration
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param Duration $duration
     */
    public function setDuration(Duration $duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
        $item->setOrder($this);

    }

    /**
     * @param Item $item
     */
    public function removeItem(Item $item)
    {
        $this->items->removeElement($item);
        $item->setOrder(null);
    }

    /**
     * Generates a unique order number and set
     * it to its variable
     */
    public function createOrderNumber()
    {
        $orderNumber = $this->generateOrderNumber();
        $this->orderNumber = $orderNumber;
    }

    /**
     * Generates an order number based on order and venue date
     * and a ramdom 8 letters word
     * @return string
     */
    private function generateOrderNumber(){
        //generate random 8 letters word
        $word = uniqid();
        return date_format($this->orderDate, 'ymd')
            . $word
            . date_format($this->venueDate, 'ymd');
    }

    /**
     * Function to return a message if it is inpossible to order for this
     * date when validating
     * @param $ticketLeft
     * @return string|void
     */
    public function checkOrderProcessing($ticketLeft){
        if ($ticketLeft < $this->items->count()){
            $message = "Due à un nombre important de vente de tickets pour la journée du " . date_format($this->venueDate, 'd/m/Y');
            $message .= ", nous ne sommes pas en mesure de donner suite à votre demande.<br>";
            $message .= "Nous en sommes désolé, et nous vous proposons de choisir une date différente pour votre visite.";
            $this->venueDate = null;
            return $message;
        }
        return;
    }

    /**
     * Function to check if the user buys a ticket for today after 14h
     * @return string|void
     */
    public function checkDurationVisit()
    {
        $today = new \DateTime();
        if ((date_format($this->venueDate, 'd/m/Y') === date_format($today,'d/m/Y')) && (date_format($today,'H') >= 14)
            && $this->duration->getName() === "Journée"){
            $message = "Vous avez choisi de venir au musée aujourd'hui et nous vous en remercions.<br>";
            $message .= "Néanmoins, il est plus de 14h, et vous avez choisi comme type de billet : Journée.<br>";
            $message .= "Nous vous recommandons de changer le type de billet pour Demi-journée afin de continuer votre achat,<br>";
            $message .= "ou de choisir un autre jour de visite... Merci.";
            return $message;
        }
        return;
    }
}