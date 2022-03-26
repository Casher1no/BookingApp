<?php
namespace App\Controller;

use App\View;
use App\Redirect;
use Carbon\Carbon;
use App\Validation\Errors;
use App\Validation\ApartmentFormValidation;
use App\Exceptions\ApartmentValidationException;
use App\Services\Apartments\Edit\EditApartmentRequest;
use App\Services\Apartments\Edit\EditApartmentService;
use App\Services\Apartments\Home\HomeApartmentService;
use App\Services\Apartments\Post\PostApartmentRequest;
use App\Services\Apartments\Post\PostApartmentService;
use App\Services\Apartments\Show\ShowApartmentRequest;
use App\Services\Apartments\Show\ShowApartmentService;
use App\Services\Apartments\Delete\DeleteApartmentRequest;
use App\Services\Apartments\Delete\DeleteApartmentService;
use App\Services\Apartments\Update\UpdateApartmentRequest;
use App\Services\Apartments\Update\UpdateApartmentService;

class HomeController
{
    public function home():View
    {
        $service = new HomeApartmentService();
        $response = $service->execute();

        return new View("Home/index", [
            "apartments" => $response,
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
        $postDates = [$_POST['select_from'],$_POST['select_to']];
        $postInfo = [
            $_POST['title'],
            $_POST['description'],
            $_POST['address'],
            $_POST['cost']
        ];
   
        $service = new PostApartmentService();
        $service->execute(new PostApartmentRequest(
            $_SESSION['userid'],
            $postDates,
            $postInfo
        ));
        
        return new Redirect("/");
    }
    public function show(array $vars):View
    {
        $service = new ShowApartmentService();
        $response = $service->execute(new ShowApartmentRequest(
            (int)$vars['id'],
            (int)$_SESSION['userid']
        ));

        $dateErrors = $_SESSION['dateErrors'];
        if (isset($_SESSION['dateErrors'])) {
            unset($_SESSION['dateErrors']);
        }

        $todaysDay = Carbon::now()->toDateString();

        return new View("Home/show", [
            'apartment' => $response->getApartment(),
            'userName' => $_SESSION['name'],
            'userId' => $_SESSION['userid'],
            'rateStatus' => $response->getRated(),
            'averageRating' =>$response->getAverageRating(),
            'reservations' => $response->getReservation(),
            'errors' => $dateErrors,
            'pickFrom' => $todaysDay,
            'pickTo'=> $response->getDateTo(),
            "disabledDates" => $response->getDisabledDates(),
            'maxDate' => $response->getMaxDate()
        ]);
    }
    public function delete(array $vars):Redirect
    {
        $service = new DeleteApartmentService();
        $service->execute(new DeleteApartmentRequest($vars['id']));

        return new Redirect('/');
    }
    public function edit(array $vars):View
    {
        $service = new EditApartmentService();
        $response = $service->execute(new EditApartmentRequest($vars['id']));

        return new View("Home/edit", [
            'apartment' => $response
        ]);
    }
    public function update(array $vars):Redirect
    {
        $id = (int)$vars['id'];
        $postInfo = [
            $_POST['title'],
            $_POST['description'],
            $_POST['address'],
            $_POST['select_to'],
            $_POST['select_from'],
            $_POST['cost']
        ];

        $service = new UpdateApartmentService();
        $service->execute(new UpdateApartmentRequest($id, $postInfo));
  
        return new Redirect("/");
    }
}
