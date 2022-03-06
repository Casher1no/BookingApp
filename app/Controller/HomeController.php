<?php
namespace App\Controller;

use App\View;
use App\Database;
use App\Redirect;
use Carbon\Carbon;
use App\Model\Apartment;
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
                $apartment['title'],
                $apartment['description'],
                $apartment['address'],
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



        $dateTo = "Long Term";
        if ($apartmentsQuery[0]['select_to'] != null) {
            $dateTo = explode(" ", $apartmentsQuery[0]['select_to'])[0];
        }

        $dateFrom = explode(" ", $apartmentsQuery[0]['select_from'])[0];

        $apartment = new Apartment(
            (int)$apartmentsQuery[0]['id'],
            $apartmentsQuery[0]['title'],
            $apartmentsQuery[0]['description'],
            $apartmentsQuery[0]['address'],
            $dateFrom,
            $dateTo
        );

        return new View("Home/show", [
            'apartment' => $apartment,
            'userName' => $_SESSION['name'],
            'userId' => $_SESSION['userid']
        ]);
    }
}
