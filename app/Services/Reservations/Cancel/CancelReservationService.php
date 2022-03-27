<?php
namespace App\Services\Reservations\Cancel;

use App\Database;

class CancelReservationService
{
    public function execute(CancelReservationRequest $request)
    {
        Database::connection()
        ->delete('apartment_pending', ['id'=>$request->getId()]);
    }
}