<?php
namespace App\Validation;

use App\Exceptions\ApartmentValidationException;

class ApartmentFormValidation
{
    private array $data;
    private array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function passes():void
    {
        foreach ($this->data as $key => $value) {
            if (empty($value)) {
                if ($key != "select_from" && $key != "select_to") {
                    $keyToUpper = ucfirst($key);
                    $this->errors[$key][] = "'{$keyToUpper}' field is required";
                }
            }
        }

                
        if (count($this->errors) > 0) {
            throw new ApartmentValidationException();
        }
    }

    public function getErrors():array
    {
        return $this->errors;
    }
}
