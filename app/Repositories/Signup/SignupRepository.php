<?php
namespace App\Repositories\Signup;

use App\Services\Signup\SignupUserRequest;

interface SignupRepository
{
    public function signUser(SignupUserRequest $request):void;
}
