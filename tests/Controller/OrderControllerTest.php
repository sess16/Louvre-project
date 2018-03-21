<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Order;
use App\Entity\Item;
use Stripe\Token;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Error\Card;

class OrderControllerTest extends WebTestCase
{
    private $container;
    private $em;

    /**
     * This function allow us to call the entity manager
     */
    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();
    }

    /**
     * This test ensure that a paid order cannot be paid again
     */
    public function testCannotPayTwiceSameOrder()
    {
        $order = $this->createMockOrder();
        $order->setOrderPaid(true);
        $this->em->flush();
        $client = static::createClient();
        $crawler = $client->request('GET','/checkout/' . $order->getId());
        $this->assertEquals(404,$client->getResponse()->getStatusCode());
    }

    /**
     * Function to create a fake order and save it in the database
     * @return Order
     */
    private function createMockOrder(){
        //generate random 10 letters word
        $order = new Order();
        $order->setVenueDate(new \DateTime('2019-02-21'));
        $order->setCustomerEmail('john.doe' . '@khalsomm.com');
        $duration = $this->em->getRepository('App:Duration')->find(1);
        $order->setDuration($duration);
        $order->createOrderNumber();
        //check that the order number is unique
        while ($this->em->getRepository('App:Order')->findByOrderNumber($order->getOrderNumber())){
            $order->createOrderNumber();
        }
        $item = new Item();
        $item->setFirstName('John');
        $item->setLastName('Doe');
        $item->setBirthDate(new \DateTime('1980-02-24'));
        $country = $this->em->getRepository('App:Country')->find(75);
        $item->setCountry($country);
        $ticket = $this->em->getRepository('App:Ticket')->find(1);
        $item->setTicket($ticket);
        $order->addItem($item);
        $this->em->persist($item);
        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }

    public function tearDown()
    {
        $this->em = null;
        $this->container = null;
    }
}