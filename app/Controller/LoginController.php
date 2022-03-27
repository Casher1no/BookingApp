<?php
namespace App\Controller;

use App\View;
use App\Database;
use App\Redirect;
use App\Validation\Errors;
use App\Validation\LoginValidation;
use App\Services\Login\LoginUserRequest;
use App\Services\Login\LoginUserService;
use App\Exceptions\LoginValidationException;

class LoginController
{
    public function login():View
    {
        return new View('/Users/login', [
            'errors' => Errors::getAll(),
            'inputs' => $_SESSION['inputs'] ?? []
        ]);
    }

    public function loginUser():Redirect
    {
        try {
            $validator = (new LoginValidation($_POST));
            $validator->passes();
        } catch (loginValidationException $exception) {
            $_SESSION['errors'] = $validator->getErrors();
            $_SESSION['inputs'] = $_POST;
            return new Redirect("/login");
        }

        $service = new LoginUserService();
        $service->execute(new LoginUserRequest(
            $_POST['email']
        ));
        
        

        return new Redirect("/");
    }
}
