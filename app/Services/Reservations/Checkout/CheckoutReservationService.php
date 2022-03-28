<?php
namespace App\Services\Reservations\Checkout;

use Carbon\Carbon;
use App\Model\Pending;
use App\Repositories\Reservations\Checkout\CheckoutRepository;
use App\Repositories\Reservations\Checkout\PdoCheckoutRepository;
use App\Services\Reservations\Checkout\CheckoutReservationRequest;

class CheckoutReservationService
{
    private CheckoutRepository $checkoutRepository;

    public function __construct()
    {
        $this->checkoutRepository = new PdoCheckoutRepository();
    }

    public function execute(CheckoutReservationRequest $request):array
    {
        $pendingQuery = $this->checkoutRepository->pendingQuery($request->getId());
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
