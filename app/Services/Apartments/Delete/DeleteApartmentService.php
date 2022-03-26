<?php
namespace App\Services\Apartments\Delete;

use App\Services\Apartments\Delete\DeleteApartmentRequest;
use App\Database;

class DeleteApartmentService
{
    public function execute(DeleteApartmentRequest $request)
    {
        Database::connection()
            ->delete('apartments', ["id" =>(int)$request->getId()]);
    }
}
