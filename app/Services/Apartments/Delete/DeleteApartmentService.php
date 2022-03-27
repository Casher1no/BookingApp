<?php
namespace App\Services\Apartments\Delete;

use App\Repositories\Apartments\Delete\DeleteApartmentRepository;
use App\Repositories\Apartments\Delete\PdoDeleteApartmentRepository;

class DeleteApartmentService
{
    private DeleteApartmentRepository $apartmentRepository;

    public function __construct()
    {
        $this->apartmentRepository = new PdoDeleteApartmentRepository();
    }

    public function execute(DeleteApartmentRequest $request):void
    {
        $repository = $this->apartmentRepository;
        $repository->delete((int)$request->getId());
    }
}
