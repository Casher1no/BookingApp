<?php

namespace App\Repositories\Login;

use App\Database;

class PdoLoginRepository implements LoginRepository
{
    public function findUser(string $email): array
    {
        $user = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where("email = ?")
            ->setParameter(0, $email)
            ->fetchAllAssociative();

        return $user;
    }
    public function userProfile(int $userId): array
    {
        $userProfile = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('user_profiles')
            ->where("user_id = ?")
            ->setParameter(0, $userId)
            ->fetchAllAssociative();
        
        return $userProfile;
    }
}
