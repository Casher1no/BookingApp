<?php
namespace App\Services\Reservations\Cancel;

use App\Repositories\Reservations\Cancel\CancelRepository;
use App\Repositories\Reservations\Cancel\PdoCancelRepository;
use App\Services\Reservations\Cancel\CancelReservationRequest;

class CancelReservationService
{
    private CancelRepository $cancelRepository;

    public function __construct()
    {
        $this->cancelRepository = new PdoCancelRepository();
    }

    public function execute(CancelReservationRequest $request):void
    {
        $this->cancelRepository->deletePending($request->getId());
    }
}
