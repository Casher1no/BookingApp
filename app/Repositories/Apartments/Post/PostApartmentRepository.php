<?php
namespace App\Repositories\Apartments\Post;

use App\Repositories\Apartments\Post\Model\Apartment;

interface PostApartmentRepository
{
    public function insert(Apartment $apartment):void;
}
