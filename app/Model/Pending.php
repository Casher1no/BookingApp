<?php
namespace App\Model;

class Pending
{
    private int $id;
    private int $apartmentId;
    private int $userId;
    private string $reservedIn;
    private string $reservedOut;
    private int $cost;
    private int $days;

    public function __construct(int $id, int $apartmentId, int $userId, string $reservedIn, string $reservedOut, int $cost, int $days)
    {
        $this->id = $id;
        $this->apartmentId = $apartmentId;
        $this->userId = $userId;
        $this->reservedIn = $reservedIn;
        $this->reservedOut = $reservedOut;
        $this->cost = $cost;
        $this->days = $days;
    }
    public function getId():int
    {
        return $this->id;
    }
    public function getApartmentId():int
    {
        return $this->apartmentId;
    }
    public function getUserId():int
    {
        return $this->userId;
    }
    public function getReservedIn():string
    {
        return $this->reservedIn;
    }
    public function getReservedOut():string
    {
        return $this->reservedOut;
    }
    public function getCost():int
    {
        return $this->cost;
    }
    public function getDays():int
    {
        return $this->days;
    }
}
