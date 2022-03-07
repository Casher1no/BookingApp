<?php
namespace App\Model;

class Reservation
{
    private int $apartmentId;
    private int $userId;
    private string $reservedIn;
    private string $reservedOut;

    public function __construct(int $apartmentId, int $userId, string $reservedIn, string $reservedOut)
    {
        $this->apartmentId = $apartmentId;
        $this->userId = $userId;
        $this->reservedIn = $reservedIn;
        $this->reservedOut = $reservedOut;
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
}
