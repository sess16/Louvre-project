<?php

namespace tests\Entity;

use App\Entity\Item;
use App\Entity\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * This checks if there is enough tickets to buy on that day.
     * @dataProvider orderProcessingValuesWithTicketLeft
     */
    public function testResponseCheckOrderProcessingWithTicketLeft($ticketLeft, $numberItem)
    {
        $order = new Order();
        $order->setVenueDate(new \DateTime('2017-11-26'));
        for ($i = 0; $i < $numberItem; $i++){
            $item = new Item();
            $order->addItem($item);
        }
        $message = $order->checkOrderProcessing($ticketLeft);
        $this->assertNull($message);
    }

    /**
     * This checks that there is no more ticket to buy on that day.
     */
    public function testResponseCheckOrderProcessingWithNOTicketLeft()
    {
        $order = new Order();
        $order->setVenueDate(new \DateTime('2017-11-26'));
        for ($i = 0; $i < 6; $i++){
            $item = new Item();
            $order->addItem($item);
        }
        $message = $order->checkOrderProcessing(3);
        $this->assertNotNull($message);
    }

    /**
     * Data values used to check if there is enough ticket left to buy
     * @return array
     */
    public function orderProcessingValuesWithTicketLeft()
    {
        return [
            [1000,8],
            [6,6]
        ];
    }

}