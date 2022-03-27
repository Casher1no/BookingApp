<?php

declare(strict_types=1);

use App\Model\Pending;
use PHPUnit\Framework\TestCase;

class PendingTest extends TestCase
{
    public function testId()
    {
        $pending = new Pending(1, 2, 4, "04-22-2019", "04-22-2022", 25, 5);
        $this->assertEquals(1, $pending->getId());
    }
    public function testApartmentId()
    {
        $pending = new Pending(1, 2, 4, "04-22-2019", "04-22-2022", 25, 5);
        $this->assertEquals(2, $pending->getApartmentId());
    }
    public function testUserId()
    {
        $pending = new Pending(1, 2, 4, "04-22-2019", "04-22-2022", 25, 5);
        $this->assertEquals(4, $pending->getUserId());
    }
    public function testReservedIn()
    {
        $pending = new Pending(1, 2, 4, "04-22-2019", "04-22-2022", 25, 5);
        $this->assertEquals("04-22-2019", $pending->getReservedIn());
    }
    public function testReservedOut()
    {
        $pending = new Pending(1, 2, 4, "04-22-2019", "04-22-2022", 25, 5);
        $this->assertEquals("04-22-2022", $pending->getReservedOut());
    }
    public function testCost()
    {
        $pending = new Pending(1, 2, 4, "04-22-2019", "04-22-2022", 25, 5);
        $this->assertEquals(25, $pending->getCost());
    }
    public function testDays()
    {
        $pending = new Pending(1, 2, 4, "04-22-2019", "04-22-2022", 25, 5);
        $this->assertEquals(5, $pending->getDays());
    }
}
