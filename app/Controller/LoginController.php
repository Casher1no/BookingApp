<?php
namespace App\Controller;

use App\View;
use App\Redirect;
use App\Database;
use App\Validation\Errors;
use App\Exceptions\LoginValidationException;
use App\Validation\LoginValidation;

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


        $user = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where("email = ?")
            ->setParameter(0, $_POST["email"])
            ->fetchAllAssociative();
            

        $userProfile = Database::connection()
                ->createQueryBuilder()
                ->select('*')
                ->from('user_profiles')
                ->where("user_id = ?")
                ->setParameter(0, $user[0]['id'])
                ->fetchAllAssociative();
                
        session_start();
        $_SESSION["userid"] = htmlentities($user[0]["id"]);
        $_SESSION["name"] = htmlentities($userProfile[0]["name"]);
        $_SESSION["surname"] = htmlentities($userProfile[0]["surname"]);
        
        

        return new Redirect("/");
    }
}
