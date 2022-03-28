<?php
namespace App\Repositories\Reservations\Accept;

interface AcceptRepository
{
    public function acceptQuery(int $apartmentId):array;
    public function insert(array $Query, int $userId):void;
    public function deletePending(int $apartmentId):void;
}
