<?php
namespace App\Repositories\Apartments\Show;

interface ApartmentRepository
{
    public function apartmentQuery(int $id):array;
    public function ratedQuery(int $userId, int $id):array;
    public function ratingQuery(int $id):array;
    public function reservationQuery(int $id):array;
}
