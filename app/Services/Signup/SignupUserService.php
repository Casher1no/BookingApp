<?php
namespace App\Services\Signup;

use App\Services\Signup\SignupUserRequest;
use App\Repositories\Signup\SignupRepository;
use App\Repositories\Signup\PdoSignupRepository;

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
