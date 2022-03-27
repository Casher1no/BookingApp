<?php
namespace App\Services\Reservations\Accept;

use App\Database;

class AcceptReservationService
{
    public function execute(AcceptReservationRequest $request)
    {
        $acceptQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartment_pending')
            ->where("id = ?")
            ->setParameter(0, $request->getApartmentId())
            ->fetchAllAssociative();

        Database::connection()->insert('apartment_reservations', [
            'user_id' => $request->getUserId(),
            'apartment_id' => $acceptQuery[0]['apartment_id'],
            'reserve_in' => $acceptQuery[0]['date_from'],
            'reserve_out' => $acceptQuery[0]['date_to']
        ]);

        Database::connection()
        ->delete('apartment_pending', [
            'id'=>$request->getApartmentId()
        ]);
    }
}
