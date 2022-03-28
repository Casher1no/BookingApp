<?php
namespace App\Repositories\Apartments\Post;

use App\Database;
use App\Repositories\Apartments\Post\Model\Apartment;

class PdoPostApartmentRepository implements PostApartmentRepository
{
    public function insert(Apartment $apartment):void
    {
        Database::connection()->insert('apartments', [
            'user_id'=> $apartment->getId(),
            'title'=>$apartment->getTitle(),
            'description'=>$apartment->getDescription(),
            'address'=>$apartment->getAddress(),
            'select_from'=>$apartment->getSelectFrom(),
            'select_to'=>$apartment->getSelectTo(),
            'cost'=> $apartment->getCost(),
            ]);
    }
}
