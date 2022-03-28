<?php
namespace App\Repositories\Reservations\Cancel;

use App\Database;

class PdoCancelRepository implements CancelRepository
{
    public function deletePending(int $id):void
    {
        Database::connection()
        ->delete('apartment_pending', ['id'=>$id]);
    }
}
