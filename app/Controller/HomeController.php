<?php
namespace App\Controller;

use App\View;
use App\Database;
use App\Redirect;
use Carbon\Carbon;
use App\Model\Apartment;
use App\Model\Reservation;
use App\Validation\Errors;
use App\Validation\ApartmentFormValidation;
use App\Exceptions\ApartmentValidationException;

class HomeController
{
    public function home():View
    {
        $apartmentsQuery = Database::connection()
        ->createQueryBuilder()
        ->select('*')
        ->from('apartments')
        ->orderBy('created_at', 'desc')
        ->fetchAllAssociative();
        
        $apartments = [];
        foreach ($apartmentsQuery as $apartment) {
            $apartments[] = new Apartment(
                (int)$apartment['id'],
                (int)$apartment['user_id'],
                $apartment['title'],
                $apartment['description'],
                $apartment['address'],
                $apartment['created_at'],
                $apartment['select_from'],
                $apartment['select_to'],
            );
        }

        return new View("Home/index", [
            "apartments" => $apartments,
            'userName' => $_SESSION['name'],
            'userSurname' => $_SESSION['surname'],
            'userId' => $_SESSION['userid']

        ]);
    }
    public function add():View
    {
        return new View('Home/post', [
            'errors' => Errors::getAll(),
            'inputs' => $_SESSION['inputs'] ?? []
        ]);
    }
    public function post():Redirect
    {
        try {
            $validator = (new ApartmentFormValidation($_POST));
            $validator->passes();
        } catch (ApartmentValidationException $exception) {
            $_SESSION['errors'] = $validator->getErrors();
            $_SESSION['inputs'] = $_POST;
            return new Redirect("/post");
        }

        $from = "";
        if ($_POST['select_from'] == "") {
            $from = explode(" ", Carbon::now()->toDateTimeString())[0];
        } else {
            $from = $_POST['select_from'];
        }

        $to = "";
        if ($_POST['select_to'] == "") {
            $to = null;
        } else {
            $to = $_POST['select_to'];
        }
        
        Database::connection()->insert('apartments', [
            'user_id'=>(int)$_SESSION['userid'],
            'title'=>$_POST['title'],
            'description'=>$_POST['description'],
            'address'=>$_POST['address'],
            'select_from'=>$from,
            'select_to'=>$to
            ]);
        return new Redirect("/");
    }
    public function show(array $vars):View
    {
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

        $averageRating=0;

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
            $dateFrom,
            $dateTo
        );

        $reservations=[];

        $reservationQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartment_reservations')
            ->where('apartment_id = ?')
            ->setParameter(0, (int) $vars['id'])
            ->fetchAllAssociative();

        foreach ($reservationQuery as $reservation) {
            $reservations[] = new Reservation(
                $reservation['apartment_id'],
                $reservation['user_id'],
                $reservation['reserve_in'],
                $reservation['reserve_out']
            );
        }

        $dateErrors = $_SESSION['dateErrors'];
        if (isset($_SESSION['dateErrors'])) {
            unset($_SESSION['dateErrors']);
        }

        return new View("Home/show", [
            'apartment' => $apartment,
            'userName' => $_SESSION['name'],
            'userId' => $_SESSION['userid'],
            'rateStatus' => $rated,
            'averageRating' =>$averageRating,
            'reservations' => $reservations,
            'errors' => $dateErrors
        ]);
    }
    public function delete(array $vars):Redirect
    {
        Database::connection()
            ->delete('apartments', ['id'=>(int)$vars['id']
            ]);
        ;
        return new Redirect('/');
    }
    public function edit(array $vars):View
    {
        $apartmentsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where("id = ?")
            ->setParameter(0, (int) $vars['id'])
            ->fetchAllAssociative();
       

        $apartment = new Apartment(
            (int)$apartmentsQuery[0]['id'],
            (int)$apartmentsQuery[0]['user_id'],
            $apartmentsQuery[0]['title'],
            $apartmentsQuery[0]['description'],
            $apartmentsQuery[0]['address'],
            $apartmentsQuery[0]['created_at'],
            $apartmentsQuery[0]['select_from'],
            $apartmentsQuery[0]['select_to'],
        );

        return new View("Home/edit", [
            'apartment' => $apartment
        ]);
    }
    public function update(array $vars):Redirect
    {
        Database::connection()->update("apartments", [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'address' => $_POST['address'],
            'select_to' => $_POST['select_to'],
            'select_from' => $_POST['select_from']
        ], ['id' => (int)$vars['id']]);

            

        return new Redirect("/");
    }
}
