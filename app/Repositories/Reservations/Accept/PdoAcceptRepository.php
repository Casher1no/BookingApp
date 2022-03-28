<?php
namespace App\Repositories\Reservations\Accept;

use App\Database;

class PdoAcceptRepository implements AcceptRepository
{
    public function acceptQuery(int $apartmentId):array
    {
        $acceptQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartment_pending')
            ->where("id = ?")
            ->setParameter(0, $apartmentId)
            ->fetchAllAssociative();

        return $acceptQuery;
    }
    public function insert(array $Query, int $userId):void
    {
        Database::connection()->insert('apartment_reservations', [
            'user_id' => $userId,
            'apartment_id' => $Query[0]['apartment_id'],
            'reserve_in' => $Query[0]['date_from'],
            'reserve_out' => $Query[0]['date_to']
        ]);
    }
    public function deletePending(int $apartmentId):void
    {
        Database::connection()
        ->delete('apartment_pending', [
            'id'=>$apartmentId
        ]);
    }
}
