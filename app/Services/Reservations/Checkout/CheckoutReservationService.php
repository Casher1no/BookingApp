<?php
namespace App\Services\Reservations\Checkout;

use App\Database;
use Carbon\Carbon;
use App\Model\Pending;

class CheckoutReservationService
{
    public function execute(CheckoutReservationRequest $request):array
    {
        $pendingQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartment_pending')
            ->where("user_id = ?")
            ->setParameter(0, $request->getId())
            ->fetchAllAssociative();

        $pending = [];

        foreach ($pendingQuery as $query) {
            $dateTo = Carbon::parse($query['date_to']);
            $dateFrom = Carbon::parse($query['date_from']);

            $diff = $dateFrom->diffInDays($dateTo);
            $cost = $diff * $query['cost'];


            $pending[] = new Pending(
                $query['id'],
                $query['apartment_id'],
                $query['user_id'],
                $query['date_from'],
                $query['date_to'],
                $cost,
                $diff
            );
        }
        return $pending;
    }
}
