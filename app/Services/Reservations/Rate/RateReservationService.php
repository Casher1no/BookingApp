<?php
namespace App\Services\Reservations\Rate;

use App\Database;

class RateReservationService
{
    public function execute(RateReservationRequest $request):void
    {
        Database::connection()->insert("apartment_rating", [
            'apartment_id' => $request->getApartmentId(),
            'user_id' => $request->getUserId(),
            'apartment_rating' => $request->getRating()
        ]);
    }
}
