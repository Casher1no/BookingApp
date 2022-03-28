<?php
namespace App\Repositories\Apartments\Home;

use App\Database;

class PdoHomeApartmentRepository implements HomeApartmentRepository
{
    public function apartmentQuery():array
    {
        $apartmentsQuery = Database::connection()
        ->createQueryBuilder()
        ->select('*')
        ->from('apartments')
        ->orderBy('created_at', 'desc')
        ->fetchAllAssociative();

        return $apartmentsQuery;
    }
}
