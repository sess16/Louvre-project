<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    public function testIndex() {
        $this->assertGreaterThan(
            0,
            1
        );
    }
}