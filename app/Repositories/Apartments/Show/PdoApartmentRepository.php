<?php
namespace App\Repositories\Apartments\Show;

use App\Database;

class PdoApartmentRepository implements ApartmentRepository
{
    public function apartmentQuery(int $id):array
    {
        $apartmentsQuery = Database::connection()
        ->createQueryBuilder()
        ->select('*')
        ->from('apartments')
        ->where("id = ?")
        ->setParameter(0, $id)
        ->fetchAllAssociative();

        return $apartmentsQuery;
    }
    public function ratedQuery(int $userId, int $id):array
    {
        $rated = Database::connection()
        ->createQueryBuilder()
        ->select('COUNT(id)')
        ->from('apartment_rating')
        ->where('user_id = ? AND apartment_id = ?')
        ->setParameter(0, $userId)
        ->setParameter(1, $id)
        ->fetchNumeric();

        return $rated;
    }
    public function ratingQuery(int $id):array
    {
        $ratingQuery = Database::connection()
        ->createQueryBuilder()
        ->select('apartment_rating')
        ->from('apartment_rating')
        ->where('apartment_id = ?')
        ->setParameter(0, $id)
        ->fetchAllAssociative();

        return $ratingQuery;
    }
    public function reservationQuery(int $id):array
    {
        $reservationQuery = Database::connection()
        ->createQueryBuilder()
        ->select('*')
        ->from('apartment_reservations')
        ->where('apartment_id = ?')
        ->setParameter(0, $id)
        ->fetchAllAssociative();

        return $reservationQuery;
    }
}
