<?php
namespace App\Services\Apartments\Edit;

use App\Database;
use App\Model\Apartment;
use App\Repositories\Apartments\Edit\EditApartmentRepository;
use App\Repositories\Apartments\Edit\PdoEditApartmentRepository;

class EditApartmentService
{
    private EditApartmentRepository $apartmentRepository;

    public function __construct()
    {
        $this->apartmentRepository = new PdoEditApartmentRepository();
    }

    public function execute(EditApartmentRequest $request):Apartment
    {
        $apartmentsQuery = $this->apartmentRepository->apartmentQuery($request->getId());

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
