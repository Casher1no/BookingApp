<?php
namespace App\Repositories\Reservations\Reserve;

use App\Services\Reservations\Reserve\ReserveReservationRequest;

interface ReserveRepository
{
    public function reservationQuery(int $apartmentId):array;
    public function apartmentQuery(int $apartmentId):array;
    public function ratedCount(int $id, int $apartmentId):array;
    public function ratingQuery(int $apartmentId):array;
    public function insertPending(ReserveReservationRequest $request, int $cost):void;
}
