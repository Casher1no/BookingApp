<?php
namespace App\Repositories\Reservations\Rate;

use App\Services\Reservations\Rate\RateReservationRequest;

interface RateRepository
{
    public function insertRating(RateReservationRequest $request):void;
}
