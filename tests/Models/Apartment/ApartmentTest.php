<?php

declare(strict_types=1);

use App\Model\Apartment;
use PHPUnit\Framework\TestCase;

class ApartmentTest extends TestCase
{
    public function testId()
    {
        $apartment = new Apartment(1, 2, "apart", "desc", "address", "createdAt", 20, "2022-02-02");
        $this->assertEquals(1, $apartment->getId());
    }
    public function testUserId()
    {
        $apartment = new Apartment(1, 2, "apart", "desc", "address", "createdAt", 20, "2022-02-02");
        $this->assertEquals(2, $apartment->getUserId());
    }
    public function testTitle()
    {
        $apartment = new Apartment(1, 2, "apart", "desc", "address", "createdAt", 20, "2022-02-02");
        $this->assertEquals("apart", $apartment->getTitle());
    }
    public function testDescription()
    {
        $apartment = new Apartment(1, 2, "apart", "desc", "address", "createdAt", 20, "2022-02-02");
        $this->assertEquals("desc", $apartment->getDescription());
    }
    public function testAddress()
    {
        $apartment = new Apartment(1, 2, "apart", "desc", "address", "createdAt", 20, "2022-02-02");
        $this->assertEquals("address", $apartment->getAddress());
    }
    public function testCreatedAt()
    {
        $apartment = new Apartment(1, 2, "apart", "desc", "address", "createdAt", 20, "2022-02-02");
        $this->assertEquals("createdAt", $apartment->getCreatedAt());
    }
    public function testCost()
    {
        $apartment = new Apartment(1, 2, "apart", "desc", "address", "createdAt", 20, "2022-02-02");
        $this->assertEquals(20, $apartment->getCost());
    }
    public function testDateFrom()
    {
        $apartment = new Apartment(1, 2, "apart", "desc", "address", "createdAt", 20, "2022-02-02");
        $this->assertEquals("2022-02-02", $apartment->getDateFrom());
    }
    public function testDateTo()
    {
        $apartment = new Apartment(1, 2, "apart", "desc", "address", "createdAt", 20, "2022-02-02");
        $this->assertEquals("Not set", $apartment->getDateTo());
    }
}
