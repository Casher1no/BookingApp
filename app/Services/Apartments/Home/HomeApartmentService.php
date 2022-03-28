<?php
namespace App\Services\Apartments\Home;

use App\Database;
use App\Model\Apartment;
use App\Repositories\Apartments\Home\HomeApartmentRepository;
use App\Repositories\Apartments\Home\PdoHomeApartmentRepository;

class HomeApartmentService
{
    private HomeApartmentRepository $apartmentRepository;

    public function __construct()
    {
        $this->apartmentRepository = new PdoHomeApartmentRepository();
    }

    public function execute():array
    {
        $apartmentsQuery = $this->apartmentRepository->apartmentQuery();
        
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
