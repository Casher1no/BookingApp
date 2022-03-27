<?php
namespace App\Services\Apartments\Show;

use App\Model\Apartment;
use Carbon\CarbonPeriod;
use App\Model\Reservation;
use App\Services\Apartments\Show\ShowApartmentRequest;
use App\Services\Apartments\Show\ShowApartmentResponse;
use App\Repositories\Apartments\Show\ApartmentRepository;
use App\Repositories\Apartments\Show\PdoApartmentRepository;

class ShowApartmentService
{
    private ApartmentRepository $apartmentRepository;

    public function __construct()
    {
        $this->apartmentRepository = new PdoApartmentRepository();
    }


    public function execute(ShowApartmentRequest $request):ShowApartmentResponse
    {
        $id = $request->getId();
        $userId = $request->getUserId();
        $repository = $this->apartmentRepository;

        $apartmentsQuery = $repository->apartmentQuery($id);
        $rated = $repository->ratedQuery($userId, $id);
        $ratingQuery = $repository->ratingQuery($id);
        $reservationQuery = $repository->reservationQuery($id);
    
        // If user rated apartment
        $rated = $rated[0] > 0 ? true : false;


        // Apartment Ratings
        $averageRating=0;

        foreach ($ratingQuery as $rating) {
            $averageRating += $rating['apartment_rating'];
        }
        $averageRating = number_format($averageRating / count($ratingQuery), 1, '.', '');
        if ($averageRating == "nan") {
            $averageRating = "0 ratings";
        }
        // --------------
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

        // Maximal date to select for reservation list

        $explodeDateTo = explode('-', $dateTo);
        $maxDate = "{$explodeDateTo[0]},{$explodeDateTo[1]},{$explodeDateTo[2]}";
        
        // ---------------------

        $reservations=[];

        foreach ($reservationQuery as $reservation) {
            $reservations[] = new Reservation(
                $reservation['apartment_id'],
                $reservation['user_id'],
                $reservation['reserve_in'],
                $reservation['reserve_out']
            );
        }

        $disabledDates = [];
        
        foreach ($reservationQuery as $reservation) {
            $period = CarbonPeriod::create($reservation['reserve_in'], $reservation['reserve_out']);
            foreach ($period as $date) {
                $disabledDates[] = $date->format('Y-m-d');
            }
        }
        return new ShowApartmentResponse(
            $apartment,
            $averageRating,
            $rated,
            $reservations,
            $dateTo,
            $disabledDates,
            $maxDate
        );
    }
}
