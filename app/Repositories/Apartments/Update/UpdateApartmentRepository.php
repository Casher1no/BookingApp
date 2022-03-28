<?php
namespace App\Repositories\Apartments\Update;

use App\Repositories\Apartments\Update\Model\Apartment;

interface UpdateApartmentRepository
{
    public function update(Apartment $apartment, int $id):void;
}
