<?php

namespace App\Controller;

use App\View;
use App\Database;
use App\Redirect;
use App\Exceptions\ReservationFormException;
use App\Validation\ReservationFormValidation;
use App\Services\Reservations\Rate\RateReservationRequest;
use App\Services\Reservations\Rate\RateReservationService;
use App\Services\Reservations\Accept\AcceptReservationRequest;
use App\Services\Reservations\Accept\AcceptReservationService;
use App\Services\Reservations\Cancel\CancelReservationRequest;
use App\Services\Reservations\Cancel\CancelReservationService;
use App\Services\Reservations\Reserve\ReserveReservationRequest;
use App\Services\Reservations\Reserve\ReserveReservationService;
use App\Services\Reservations\Checkout\CheckoutReservationRequest;
use App\Services\Reservations\Checkout\CheckoutReservationService;

class ReservationController
{
    public function rate(array $vars): Redirect
    {
        $apartmentId = (int)$vars['id'];

        $service = new RateReservationService();
        $service->execute(new RateReservationRequest(
            $apartmentId,
            $_SESSION['userid'],
            $_POST['rating']
        ));

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

        try {
            $validator = (new ReservationFormValidation($inputs));
            $validator->passes();
        } catch (ReservationFormException $exception) {
            $_SESSION['dateErrors'] = $validator->getErrors();
            $_SESSION['inputs'] = $_POST;
            return new Redirect("/show/{$apartmentId}");
        }

        $service = new ReserveReservationService();
        $service->execute(new ReserveReservationRequest(
            $apartmentId,
            $_SESSION['userid'],
            $inputs
        ));
        
        return new Redirect("/checkout/{$_SESSION['userid']}");
    }
    public function checkout(array $vars): View
    {
        $userId = (int) $vars['id'];
        
        $service = new CheckoutReservationService();
        $response = $service->execute(new CheckoutReservationRequest(
            $userId
        ));

        return new View("/Home/reserve", [
            "allPending" => $response
        ]);
    }
    public function accept(array $vars): Redirect
    {
        $apartmentId = (int) $vars['id'];
        
        $service = new AcceptReservationService();
        $service->execute(new AcceptReservationRequest(
            $apartmentId,
            $_SESSION['userid']
        ));

        return new Redirect("/");
    }
    public function cancel(array $vars): Redirect
    {
        $service = new CancelReservationService();
        $service->execute(new CancelReservationRequest(
            (int)$vars['id']
        ));

        return new Redirect("/");
    }
}
