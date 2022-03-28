<?php
namespace App\Repositories\Apartments\Post\Model;

class Apartment
{
    private int $id;
    private string $title;
    private string $description;
    private string $address;
    private ?string $selectFrom;
    private ?string $selectTo;
    private int $cost;

    public function __construct(int $id, string $title, string $description, string $address, ?string $selectFrom, ?string $selectTo, int $cost)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->address = $address;
        $this->selectFrom = $selectFrom;
        $this->selectTo = $selectTo;
        $this->cost = $cost;
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
    public function getSelectFrom(): ?string
    {
        return $this->selectFrom;
    }
    public function getSelectTo(): ?string
    {
        return $this->selectTo;
    }
    public function getCost():int
    {
        return $this->cost;
    }
}
