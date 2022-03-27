<?php
namespace App\Repositories\Apartments\Delete;

interface DeleteApartmentRepository
{
    public function delete(int $id):void;
}
