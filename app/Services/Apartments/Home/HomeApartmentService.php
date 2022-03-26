<?php
namespace App\Services\Apartments\Home;

use App\Database;
use App\Model\Apartment;

class HomeApartmentService
{
    public function execute():array
    {
        $apartmentsQuery = Database::connection()
        ->createQueryBuilder()
        ->select('*')
        ->from('apartments')
        ->orderBy('created_at', 'desc')
        ->fetchAllAssociative();
        
        $apartments = [];
        foreach ($apartmentsQuery as $apartment) {
            $apartments[] = new Apartment(
                (int)$apartment['id'],
                (int)$apartment['user_id'],
                $apartment['title'],
                $apartment['description'],
                $apartment['address'],
                $apartment['created_at'],
                $apartment['cost'],
                $apartment['select_from'],
                $apartment['select_to'],
            );
        }
        return $apartments;
    }
}
