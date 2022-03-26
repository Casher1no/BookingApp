<?php
namespace App\Services\Apartments\Show;

use App\Model\Apartment;

class ShowApartmentResponse
{
    private Apartment $apartment;
    private string $averageRating;
    private bool $rated;
    private array $reservation;
    private string $dateTo;
    private array $disabledDates;
    private string $maxDate;

    public function __construct(Apartment $apartment, string $averageRating, bool $rated, array $reservation, string $dateTo, array $disabledDates, string $maxDate)
    {
        $this->apartment = $apartment;
        $this->averageRating = $averageRating;
        $this->rated = $rated;
        $this->reservation = $reservation;
        $this->dateTo = $dateTo;
        $this->disabledDates = $disabledDates;
        $this->maxDate = $maxDate;
    }
    public function getApartment():Apartment
    {
        return $this->apartment;
    }
    public function getAverageRating():string
    {
        return $this->averageRating;
    }
    public function getRated():bool
    {
        return $this->rated;
    }
    public function getReservation():array
    {
        return $this->reservation;
    }
    public function getDateTo():string
    {
        return $this->dateTo;
    }
    public function getDisabledDates():array
    {
        return $this->disabledDates;
    }
    public function getMaxDate():string
    {
        return $this->maxDate;
    }
}
