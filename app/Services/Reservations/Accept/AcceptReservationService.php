<?php
namespace App\Services\Reservations\Accept;

use App\Repositories\Reservations\Accept\AcceptRepository;
use App\Repositories\Reservations\Accept\PdoAcceptRepository;
use App\Services\Reservations\Accept\AcceptReservationRequest;

class AcceptReservationService
{
    private AcceptRepository $acceptRepository;

    public function __construct()
    {
        $this->acceptRepository = new PdoAcceptRepository();
    }

    public function execute(AcceptReservationRequest $request):void
    {
        $acceptQuery = $this->acceptRepository->acceptQuery($request->getApartmentId());
        $this->acceptRepository->insert($acceptQuery, $request->getUserId());
        $this->acceptRepository->deletePending($request->getApartmentId());
    }
}
