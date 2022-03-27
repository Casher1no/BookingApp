<?php
namespace App\Repositories\Apartments\Delete;

use App\Database;

class PdoDeleteApartmentRepository implements DeleteApartmentRepository
{
    public function delete(int $id):void
    {
        Database::connection()->delete('apartments', ["id" =>$id]);
    }
}
