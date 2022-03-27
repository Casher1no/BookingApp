<?php
namespace App\Services\Login;

use App\Database;
use App\Services\Login\LoginUserRequest;

class LoginUserService
{
    public function execute(LoginUserRequest $request):void
    {
        $user = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where("email = ?")
            ->setParameter(0, $request->getEmail())
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
    }
}
