<?php
namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\SendMail;
use App\Models\User;
use App\Service\AuthService;
use App\Validator\BaseValidator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Register;

class AuthController extends Controller
{

    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request);
    }

    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }

    public function verifyToken (Request $request) {
       return $this->authService->verifyToken($request);
    }

    public function changePassword (Request $request) {
        return $this->authService->changePassword($request);
    }

    public function reVerify (Request $request) {
        return $this->authService->reVerify($request);
    }

    public function forgetPassword (Request $request) {
        return $this->authService->forgetPassword($request);
    }
}
