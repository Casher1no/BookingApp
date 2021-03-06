<?php
namespace App\Repositories\Apartments\Edit;

use App\Database;

class PdoEditApartmentRepository implements EditApartmentRepository
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
}
