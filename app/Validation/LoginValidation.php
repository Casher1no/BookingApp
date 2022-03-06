<?php
namespace App\Validation;

use App\Exceptions\LoginValidationException;
use App\Database;

class LoginValidation
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
                $keyToUpper = ucfirst($key);
                $this->errors[$key][] = "{$keyToUpper} field is required";
            }
        }

        

        $databaseInfo = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where("email = ?")
            ->setParameter(0, $_POST["email"])
            ->fetchAllAssociative();
        if ($databaseInfo != null) {
            $user = $databaseInfo;
                

            $pwdHashed = $user[0]["password"];
            $checkPwd = password_verify($_POST['password'], $pwdHashed);

            if (!$checkPwd) {
                $this->errors["Wrong password"][] = "Wrong Password";
            }
        } else {
            $this->errors["Wrong Email"][] = "Wrong Email";
        }
        if (count($this->errors) > 0) {
            throw new LoginValidationException();
        }
    }

    public function getErrors():array
    {
        return $this->errors;
    }
}
