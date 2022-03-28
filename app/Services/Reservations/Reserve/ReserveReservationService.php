<?php
namespace App\Services\Reservations\Reserve;

use App\Database;
use App\Model\Apartment;
use App\Model\Reservation;
use App\Repositories\Reservations\Reserve\ReserveRepository;
use App\Repositories\Reservations\Reserve\PdoReserveRepository;
use App\Services\Reservations\Reserve\ReserveReservationRequest;

class ReserveReservationService
{
    private ReserveRepository $reserveRepository;

    public function __construct()
    {
        $this->reserveRepository = new PdoReserveRepository();
    }

    public function execute(ReserveReservationRequest $request):void
    {
        $reservations = [];


        $reservationQuery = $this->reserveRepository->reservationQuery($request->getApartmentId());


        foreach ($reservationQuery as $reservation) {
            $reservations[] = new Reservation(
                $reservation['apartment_id'],
                $reservation['user_id'],
                $reservation['reserve_in'],
                $reservation['reserve_out']
            );
        }

        $apartmentsQuery = $this->reserveRepository->apartmentQuery($request->getApartmentId());
        $rated = $this->reserveRepository->ratedCount($request->getId(), $request->getApartmentId());

        // If user rated article
        $rated = $rated[0] > 0 ? true : false;

        $ratingQuery = $this->reserveRepository->ratingQuery($request->getApartmentId());

        $averageRating = 0;

        foreach ($ratingQuery as $rating) {
            $averageRating += $rating['apartment_rating'];
        }
        $averageRating = number_format($averageRating / count($ratingQuery), 1, '.', '');
        if ($averageRating == "nan") {
            $averageRating = "0 ratings";
        }

        $dateTo = "Long Term";
        if ($apartmentsQuery[0]['select_to'] != null) {
            $dateTo = explode(" ", $apartmentsQuery[0]['select_to'])[0];
        }

        $dateFrom = explode(" ", $apartmentsQuery[0]['select_from'])[0];

        $apartment = new Apartment(
            (int)$apartmentsQuery[0]['id'],
            (int)$apartmentsQuery[0]['user_id'],
            $apartmentsQuery[0]['title'],
            $apartmentsQuery[0]['description'],
            $apartmentsQuery[0]['address'],
            $apartmentsQuery[0]['created_at'],
            $apartmentsQuery[0]['cost'],
            $dateFrom,
            $dateTo
        );
        
        $this->reserveRepository->insertPending($request, $apartmentsQuery[0]['cost']);
    }
}
