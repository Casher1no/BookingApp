<?php
namespace App\Model;

class Apartment
{
    private int $id;
    private string $title;
    private string $description;
    private string $address;
    private ?string $dateFrom;
    private ?string $dateTo;

    public function __construct(int $id, string $title, string $description, string $address, ?string $dateFrom, ?string $dateTo = "Not set")
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->address = $address;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }
    public function getId():int
    {
        return $this->id;
    }
    public function getTitle():string
    {
        return $this->title;
    }
    public function getDescription():string
    {
        return $this->description;
    }
    public function getAddress():string
    {
        return $this->address;
    }
    public function getDateFrom():string
    {
        return $this->dateFrom;
    }
    public function getDateTo():string
    {
        return $this->dateTo;
    }
}
