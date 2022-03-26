<?php
namespace App\Services\Apartments\Update;

class UpdateApartmentRequest
{
    private int $id;
    private array $info;

    public function __construct(int $id, array $info)
    {
        $this->id = $id;
        $this->info = $info;
    }
    public function getId():int
    {
        return $this->id;
    }
    public function getInfo():array
    {
        return $this->info;
    }
}
