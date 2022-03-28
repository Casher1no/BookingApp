<?php
namespace App\Repositories\Reservations\Rate;

use App\Database;
use App\Services\Reservations\Rate\RateReservationRequest;

class PdoRateRepository implements RateRepository
{
    public function insertRating(RateReservationRequest $request):void
    {
        Database::connection()->insert("apartment_rating", [
            'apartment_id' => $request->getApartmentId(),
            'user_id' => $request->getUserId(),
            'apartment_rating' => $request->getRating()
        ]);
    }
}
