<?php
namespace App\Services\Signup\SignupUser;

use App\Database;

class SignupUserService
{
    public function execute(SignupUserRequest $request)
    {
        Database::connection()
            ->insert('users', [
                'email' => $request->getEmail(),
                'password' => $request->getPassword(),
            ]);
            
        $createdUser = Database::connection()
            ->createQueryBuilder()
            ->select('id')
            ->from('users')
            ->where("email = ?")
            ->setParameter(0, $request->getEmail())
            ->fetchAllAssociative();
            
        Database::connection()
            ->insert('user_profiles', [
                'user_id' => $createdUser[0]['id'],
                'name' => $request->getName(),
                'surname' => $request->getSurname(),
                'birthday' => $request->getBirthday(),
            ]);
    }
}
