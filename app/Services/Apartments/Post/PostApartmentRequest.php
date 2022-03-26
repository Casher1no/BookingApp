<?php
namespace App\Services\Apartments\Post;

class PostApartmentRequest
{
    private int $id;
    private array $datesFromTo;
    private array $apartmentInfo;

    public function __construct(int $id, array $datesFromTo, array $apartmentInfo)
    {
        $this->id = $id;
        $this->datesFromTo = $datesFromTo;
        $this->apartmentInfo = $apartmentInfo;
    }

    public function getId():int
    {
        return $this->id;
    }
    public function getDatesFromTo():array
    {
        return $this->datesFromTo;
    }
    public function getApartmentInfo():array
    {
        return $this->apartmentInfo;
    }
}
