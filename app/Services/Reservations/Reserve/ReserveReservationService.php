<?php
namespace App\Services\Reservations\Reserve;

use App\Database;
use App\Model\Apartment;
use App\Model\Reservation;

class ReserveReservationService
{
    public function execute(ReserveReservationRequest $request):void
    {
        $reservations = [];

        $reservationQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartment_reservations')
            ->where('apartment_id = ?')
            ->setParameter(0, $request->getApartmentId())
            ->fetchAllAssociative();

        foreach ($reservationQuery as $reservation) {
            $reservations[] = new Reservation(
                $reservation['apartment_id'],
                $reservation['user_id'],
                $reservation['reserve_in'],
                $reservation['reserve_out']
            );
        }

        $apartmentsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where("id = ?")
            ->setParameter(0, $request->getApartmentId())
            ->fetchAllAssociative();

        $rated = Database::connection()
            ->createQueryBuilder()
            ->select('COUNT(id)')
            ->from('apartment_rating')
            ->where('user_id = ? AND apartment_id = ?')
            ->setParameter(0, $request->getId())
            ->setParameter(1, $request->getApartmentId())
            ->fetchNumeric();

        // If user rated article
        $rated = $rated[0] > 0 ? true : false;

        $ratingQuery = Database::connection()
            ->createQueryBuilder()
            ->select('apartment_rating')
            ->from('apartment_rating')
            ->where('apartment_id = ?')
            ->setParameter(0, $request->getApartmentId())
            ->fetchAllAssociative();

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
        

        Database::connection()->insert('apartment_pending', [
            'user_id' => $request->getId(),
            'date_from' => $request->getInputs()[0]['userFrom'],
            'date_to' => $request->getInputs()[0]['userTo'],
            'apartment_id' => $request->getInputs()[0]['apartmentId'],
            'cost' => $apartmentsQuery[0]['cost']
        ]);
    }
}
