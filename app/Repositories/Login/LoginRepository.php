<?php
namespace App\Repositories\Login;

interface LoginRepository
{
    public function findUser(string $email):array;
    public function userProfile(int $userId):array;
}
