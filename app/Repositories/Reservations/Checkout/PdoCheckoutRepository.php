<?php
namespace App\Repositories\Reservations\Checkout;

use App\Database;

class PdoCheckoutRepository implements CheckoutRepository
{
    public function pendingQuery(int $id):array
    {
        $pendingQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartment_pending')
            ->where("user_id = ?")
            ->setParameter(0, $id)
            ->fetchAllAssociative();
        
        return $pendingQuery;
    }
}
