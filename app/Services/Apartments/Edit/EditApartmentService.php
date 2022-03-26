<?php
namespace App\Services\Apartments\Edit;

use App\Database;
use App\Model\Apartment;

class EditApartmentService
{
    public function execute(EditApartmentRequest $request):Apartment
    {
        $apartmentsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where("id = ?")
            ->setParameter(0, $request->getId())
            ->fetchAllAssociative();
       

        $apartment = new Apartment(
            (int)$apartmentsQuery[0]['id'],
            (int)$apartmentsQuery[0]['user_id'],
            $apartmentsQuery[0]['title'],
            $apartmentsQuery[0]['description'],
            $apartmentsQuery[0]['address'],
            $apartmentsQuery[0]['created_at'],
            $apartmentsQuery[0]['cost'],
            $apartmentsQuery[0]['select_from'],
            $apartmentsQuery[0]['select_to'],
        );
        return $apartment;
    }
}
