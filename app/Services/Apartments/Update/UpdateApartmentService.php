<?php
namespace App\Services\Apartments\Update;

use App\Database;
use App\Repositories\Apartments\Update\Model\Apartment;
use App\Services\Apartments\Update\UpdateApartmentRequest;
use App\Repositories\Apartments\Update\UpdateApartmentRepository;
use App\Repositories\Apartments\Update\PdoUpdateApartmentRepository;

class UpdateApartmentService
{
    private UpdateApartmentRepository $apartmentRepository;

    public function __construct()
    {
        $this->apartmentRepository = new PdoUpdateApartmentRepository();
    }

    public function execute(UpdateApartmentRequest $request):void
    {
        $apartment = new Apartment(
            $request->getInfo()[0],
            $request->getInfo()[1],
            $request->getInfo()[2],
            $request->getInfo()[3],
            $request->getInfo()[4],
            $request->getInfo()[5],
        );

        $this->apartmentRepository->update($apartment, $request->getId());
    }
}
