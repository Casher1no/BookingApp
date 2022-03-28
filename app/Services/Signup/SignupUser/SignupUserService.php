<?php
namespace App\Services\Signup\SignupUser;

use App\Database;
use App\Repositories\Signup\SignupRepository;
use App\Repositories\Signup\PdoSignupRepository;
use App\Services\Signup\SignupUser\SignupUserRequest;

class SignupUserService
{
    private SignupRepository $signupRepository;

    public function __construct()
    {
        $this->signupRepository = new PdoSignupRepository();
    }

    public function execute(SignupUserRequest $request)
    {
        $this->signupRepository->signUser($request);
    }
}
