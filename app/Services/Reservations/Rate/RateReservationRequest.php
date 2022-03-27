<?php
namespace App\Services\Reservations\Rate;

class RateReservationRequest
{
    private int $apartmentId;
    private int $userId;
    private int $rating;

    public function __construct(int $apartmentId, int $userId, int $rating)
    {
        $this->apartmentId = $apartmentId;
        $this->userId = $userId;
        $this->rating = $rating;
    }
    public function getApartmentId():int
    {
        return $this->apartmentId;
    }
    public function getUserId():int
    {
        return $this->userId;
    }
    public function getRating():int
    {
        return $this->rating;
    }
}
