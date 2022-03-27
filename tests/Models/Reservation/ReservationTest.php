<?php

declare(strict_types=1);


use App\Model\Reservation;
use PHPUnit\Framework\TestCase;

class ReservationTest extends TestCase
{
    public function testApartmentId()
    {
        $reservation = new Reservation(10, 5, "01-01-2020", "05-01-2020");
        $this->assertEquals(10, $reservation->getApartmentId());
    }
    public function testUserId()
    {
        $reservation = new Reservation(10, 5, "01-01-2020", "05-01-2020");
        $this->assertEquals(5, $reservation->getUserId());
    }
    public function testReservedIn()
    {
        $reservation = new Reservation(10, 5, "01-01-2020", "05-01-2020");
        $this->assertEquals("01-01-2020", $reservation->getReservedIn());
    }
    public function testReservedOut()
    {
        $reservation = new Reservation(10, 5, "01-01-2020", "05-01-2020");
        $this->assertEquals("05-01-2020", $reservation->getReservedOut());
    }
}
