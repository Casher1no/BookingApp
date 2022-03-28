<?php

namespace App\Repositories\Signup;

use App\Database;
use App\Services\Signup\SignupUser\SignupUserRequest;

class PdoSignupRepository implements SignupRepository
{
    public function signUser(SignupUserRequest $request): void
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
