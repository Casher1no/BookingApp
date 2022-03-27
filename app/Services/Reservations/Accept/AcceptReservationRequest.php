<?php
namespace App\Services\Reservations\Accept;

class AcceptReservationRequest
{
    private int $apartmentId;
    private int $userId;

    public function __construct(int $apartmentId, int $userId)
    {
        $this->apartmentId = $apartmentId;
        $this->userId = $userId;
    }
    public function getApartmentId():int
    {
        return $this->apartmentId;
    }
    public function getUserId():int
    {
        return $this->userId;
    }
}
