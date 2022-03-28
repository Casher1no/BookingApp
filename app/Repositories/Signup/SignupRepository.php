<?php
namespace App\Repositories\Signup;

use App\Services\Signup\SignupUser\SignupUserRequest;

interface SignupRepository
{
    public function signUser(SignupUserRequest $request):void;
}
