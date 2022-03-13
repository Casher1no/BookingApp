<?php

namespace App\Controller;

use App\View;
use App\Database;
use App\Redirect;
use Carbon\Carbon;
use App\Model\Pending;
use App\Model\Apartment;
use App\Model\Reservation;
use App\Exceptions\ReservationFormException;
use App\Validation\ReservationFormValidation;

class ReservationController
{
    public function rate(array $vars): Redirect
    {
        $apartmentId = (int)$vars['id'];
        Database::connection()->insert("apartment_rating", [
            'apartment_id' => $apartmentId,
            'user_id' => $_SESSION['userid'],
            'apartment_rating' => $_POST['rating']
        ]);
        return new Redirect("/show/{$apartmentId}");
    }
    public function reserve(array $vars): Redirect
    {
        // Formats date
        $userDateFrom = explode("/", $_POST['date_from']);
        $userDateTo = explode("/", $_POST['date_to']);

        $userDateFrom = "{$userDateFrom[2]}-{$userDateFrom[0]}-{$userDateFrom[1]}";
        $userDateTo = "{$userDateTo[2]}-{$userDateTo[0]}-{$userDateTo[1]}";
        //--------------
        $apartmentId = (int)$vars['id'];


        $inputs = [];
        $inputs[] = [
            "userFrom" => $userDateFrom,
            "userTo" => $userDateTo,
            "apartmentId" => $apartmentId,
            "post" => $_POST
        ];

        $reservations = [];

        $reservationQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartment_reservations')
            ->where('apartment_id = ?')
            ->setParameter(0, $apartmentId)
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
            ->setParameter(0, (int) $vars['id'])
            ->fetchAllAssociative();

        $rated = Database::connection()
            ->createQueryBuilder()
            ->select('COUNT(id)')
            ->from('apartment_rating')
            ->where('user_id = ? AND apartment_id = ?')
            ->setParameter(0, $_SESSION['userid'])
            ->setParameter(1, (int)$vars['id'])
            ->fetchNumeric();

        // If user rated article
        $rated = $rated[0] > 0 ? true : false;

        $ratingQuery = Database::connection()
            ->createQueryBuilder()
            ->select('apartment_rating')
            ->from('apartment_rating')
            ->where('apartment_id = ?')
            ->setParameter(0, (int)$vars['id'])
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




        try {
            $validator = (new ReservationFormValidation($inputs));
            $validator->passes();
        } catch (ReservationFormException $exception) {
            $_SESSION['dateErrors'] = $validator->getErrors();
            $_SESSION['inputs'] = $_POST;
            return new Redirect("/show/{$apartmentId}");
        }

        Database::connection()->insert('apartment_pending', [
            'user_id' => (int)$_SESSION['userid'],
            'date_from' => $userDateFrom,
            'date_to' => $userDateTo,
            'apartment_id' => $apartmentId,
            'cost' => $apartmentsQuery[0]['cost']
        ]);
        return new Redirect("/checkout/{$_SESSION['userid']}");
    }
    public function checkout(array $vars): View
    {
        $pendingQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartment_pending')
            ->where("user_id = ?")
            ->setParameter(0, (int) $vars['id'])
            ->fetchAllAssociative();

        $pending = [];

        foreach ($pendingQuery as $query) {
            $dateTo = Carbon::parse($query['date_to']);
            $dateFrom = Carbon::parse($query['date_from']);

            $diff = $dateFrom->diffInDays($dateTo);
            $cost = $diff * $query['cost'];


            $pending[] = new Pending(
                $query['id'],
                $query['apartment_id'],
                $query['user_id'],
                $query['date_from'],
                $query['date_to'],
                $cost,
                $diff
            );
        }

        return new View("/Home/reserve", [
            "allPending" => $pending
        ]);
    }
    public function accept(array $vars): Redirect
    {
        $acceptQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartment_pending')
            ->where("id = ?")
            ->setParameter(0, (int) $vars['id'])
            ->fetchAllAssociative();

        Database::connection()->insert('apartment_reservations', [
            'user_id' => (int)$_SESSION['userid'],
            'apartment_id' => $acceptQuery[0]['apartment_id'],
            'reserve_in' => $acceptQuery[0]['date_from'],
            'reserve_out' => $acceptQuery[0]['date_to']
        ]);

        Database::connection()
        ->delete('apartment_pending', ['id'=>(int)$vars['id']
        ]);
        ;


        return new Redirect("/");
    }
    public function cancel(array $vars): Redirect
    {
        Database::connection()
        ->delete('apartment_pending', ['id'=>(int)$vars['id']
        ]);

        return new Redirect("/");
    }
}
