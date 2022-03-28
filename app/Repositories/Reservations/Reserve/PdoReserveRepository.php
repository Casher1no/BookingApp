<?php
namespace App\Repositories\Reservations\Reserve;

use App\Database;
use App\Services\Reservations\Reserve\ReserveReservationRequest;

class PdoReserveRepository implements ReserveRepository
{
    public function reservationQuery(int $apartmentId):array
    {
        $reservationQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartment_reservations')
            ->where('apartment_id = ?')
            ->setParameter(0, $apartmentId)
            ->fetchAllAssociative();

        return $reservationQuery;
    }
    public function apartmentQuery(int $apartmentId):array
    {
        $apartmentsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where("id = ?")
            ->setParameter(0, $apartmentId)
            ->fetchAllAssociative();

        return $apartmentsQuery;
    }
    public function ratedCount(int $id, int $apartmentId):array
    {
        $rated = Database::connection()
            ->createQueryBuilder()
            ->select('COUNT(id)')
            ->from('apartment_rating')
            ->where('user_id = ? AND apartment_id = ?')
            ->setParameter(0, $id)
            ->setParameter(1, $apartmentId)
            ->fetchNumeric();

        return $rated;
    }
    public function ratingQuery(int $apartmentId):array
    {
        $ratingQuery = Database::connection()
            ->createQueryBuilder()
            ->select('apartment_rating')
            ->from('apartment_rating')
            ->where('apartment_id = ?')
            ->setParameter(0, $apartmentId)
            ->fetchAllAssociative();

        return $ratingQuery;
    }
    public function insertPending(ReserveReservationRequest $request, int $cost):void
    {
        Database::connection()->insert('apartment_pending', [
            'user_id' => $request->getId(),
            'date_from' => $request->getInputs()[0]['userFrom'],
            'date_to' => $request->getInputs()[0]['userTo'],
            'apartment_id' => $request->getInputs()[0]['apartmentId'],
            'cost' => $cost
        ]);
    }
}
