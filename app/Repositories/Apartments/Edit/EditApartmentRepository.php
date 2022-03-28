<?php
namespace App\Repositories\Apartments\Edit;

interface EditApartmentRepository
{
    public function apartmentQuery(int $id):array;
}
