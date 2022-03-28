<?php
namespace App\Repositories\Reservations\Checkout;

interface CheckoutRepository
{
    public function pendingQuery(int $id):array;
}
