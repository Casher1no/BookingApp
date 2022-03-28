<?php
namespace App\Services\Reservations\Rate;

use App\Repositories\Reservations\Rate\RateRepository;
use App\Repositories\Reservations\Rate\PdoRateRepository;
use App\Services\Reservations\Rate\RateReservationRequest;

class RateReservationService
{
    private RateRepository $rateRepository;

    public function __construct()
    {
        $this->rateRepository = new PdoRateRepository();
    }

    public function execute(RateReservationRequest $request):void
    {
        $this->rateRepository->insertRating($request);
    }
}
