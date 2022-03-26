<?php
namespace App\Services\Apartments\Delete;

class DeleteApartmentRequest
{
    private int $id;
    
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId():int
    {
        return $this->id;
    }
}
