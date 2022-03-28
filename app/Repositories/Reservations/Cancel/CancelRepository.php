<?php
namespace App\Repositories\Reservations\Cancel;

interface CancelRepository
{
    public function deletePending(int $id):void;
}
