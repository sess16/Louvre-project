<?php

namespace tests\Entity;

use App\Entity\Item;
use App\Entity\Order;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\DateTime;

class ItemTest extends TestCase
{
    /**
    * This test checks that we get the right ticket depending of the age of
    * the ticket holder, and if the reduced rate box has been ticked.
    *
    * @dataProvider birthDateAndTicketRate
    */
    public function testCalculateAdultTicketRate($birthdate, $itemRate, $reducedRate)
    {
        $order = new Order();
        $item = new Item();
        $order->setVenueDate(new \DateTime('2017-11-26'));
        $item->setBirthDate($birthdate);
        $item->setReducedRate($reducedRate);
        $order->addItem($item);
        $item->calculateTicketRate();

        $this->assertSame($itemRate, $item->getTicketRate());
    }

    /**
    * This checks if the age is less than 4 years old. It will return an
    * logic exception.
    */
    public function testCalculateAdultTicketRateLessThanFour()
    {
        $order = new Order();
        $item = new Item();
        $order->setVenueDate(new \DateTime('2017-11-26'));
        $item->setBirthDate(new \DateTime('2016-08-12'));
        $order->addItem($item);
        $this->expectException('LogicException');
        $item->calculateTicketRate();
    }

    /**
    * Data values used for testing calculation of ticket rate
    *
    * @return array
    */
    public function birthDateAndTicketRate()
    {
        return [
        [new \DateTime('2000-01-12'), Item::ADULT_RATE, false],
        [new \DateTime('2011-06-25'), Item::CHILD_RATE, false],
        [new \DateTime('1938-11-10'), Item::SENIOR_RATE, false],
        [new \DateTime('2000-01-12'), Item::REDUCED_RATE, true],
        [new \DateTime('2011-06-25'), Item::REDUCED_RATE, true],
        [new \DateTime('1938-11-10'), Item::REDUCED_RATE, true]
        ];
    }
}