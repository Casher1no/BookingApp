<?php
namespace App\Services\Reservations\Reserve;

class ReserveReservationRequest
{
    private int $apartmentId;
    private int $id;
    private array $inputs;

    public function __construct(int $apartmentId, int $id, array $inputs)
    {
        $this->apartmentId = $apartmentId;
        $this->id = $id;
        $this->inputs = $inputs;
    }
    public function getApartmentId():int
    {
        return $this->apartmentId;
    }
    public function getId():int
    {
        return $this->id;
    }
    public function getInputs():array
    {
        return $this->inputs;
    }
}
