<?php
namespace App\Repositories\Apartments\Update;

use App\Database;
use App\Repositories\Apartments\Update\Model\Apartment;

class PdoUpdateApartmentRepository implements UpdateApartmentRepository
{
    public function update(Apartment $apartment, int $id):void
    {
        Database::connection()->update("apartments", [
            'title' => $apartment->getTitle(),
            'description' => $apartment->getDescription(),
            'address' => $apartment->getAddress(),
            'select_to' => $apartment->getSelectTo(),
            'select_from' => $apartment->getSelectFrom(),
            'cost' => $apartment->getCost(),
        ], ['id' => $id]);
    }
}
