<?php
namespace App\Model;

class Apartment
{
    private int $id;
    private int $userId;
    private string $title;
    private string $description;
    private string $address;
    private string $createdAt;
    private ?string $dateFrom;
    private ?string $dateTo;

    public function __construct(int $id, int $userId, string $title, string $description, string $address, string $createdAt, ?string $dateFrom, ?string $dateTo = "Not set")
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->address = $address;
        $this->createdAt = $createdAt;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }
    public function getId():int
    {
        return $this->id;
    }
    public function getUserId():int
    {
        return $this->userId;
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
    public function getCreatedAt():string
    {
        return $this->createdAt;
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
