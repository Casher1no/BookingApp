<?php
namespace App\Validation;

use App\Database;
use Carbon\Carbon;
use App\Exceptions\LoginValidationException;
use App\Exceptions\ReservationFormException;

class ReservationFormValidation
{
    private array $data;
    private array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function passes():void
    {
        $input = $this->data[0];

        $databaseInfo = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where("id = ?")
            ->setParameter(0, $input['apartmentId'])
            ->fetchAllAssociative();
        

        $userFrom = $input['userFrom'];
        $userTo = $input['userTo'];
        $selectFrom = explode(" ", $databaseInfo[0]['select_from'])[0];
        $selectTo = explode(" ", $databaseInfo[0]['select_to'])[0];

        $userFrom = new Carbon($userFrom);
        $userTo = new Carbon($userTo);
        $selectFrom = new Carbon($selectFrom);
        $selectTo = new Carbon($selectTo);

        if ($databaseInfo[0]['select_to'] == null) {
            $result = $userFrom->gt($selectFrom);
            if (!$result) {
                $this->errors["Wrong 'From' date"][] = "Wrong 'From' date";
            }
            $diff = $userFrom->gt($userTo);
            if ($diff) {
                $this->errors["Wrong reservation"][] = "Wrong reservation";
            }
        } else {
            $result = $userFrom->gt($selectFrom);
            if (!$result) {
                $this->errors["Wrong 'From' date"][] = "Wrong 'From' date";
            }
            $diff = $userFrom->gt($userTo);
            if ($diff) {
                $this->errors["Wrong reservation"][] = "Wrong reservation";
            }
            $validTo = $selectTo->gt($userTo);
            if (!$validTo) {
                $this->errors["Reservation out of range"][] = "Reservation out of range";
            }
        }
        $reservedFrom = Database::connection()
        ->createQueryBuilder()
        ->select('reserve_in')
        ->from('apartment_reservations')
        ->where("reserve_in BETWEEN '{$userFrom}' AND '{$userTo}'")
        ->fetchAllAssociative();

        $reservedTo = Database::connection()
        ->createQueryBuilder()
        ->select('reserve_in')
        ->from('apartment_reservations')
        ->where("reserve_out BETWEEN '{$userFrom}' AND '{$userTo}'")
        ->fetchAllAssociative();

        if (!empty($reservedFrom || $reservedTo)) {
            $this->errors["Date is taken"][] = "Date is taken";
        }
        
        if (count($this->errors) > 0) {
            throw new ReservationFormException();
        }
    }

    public function getErrors():array
    {
        return $this->errors;
    }
}
