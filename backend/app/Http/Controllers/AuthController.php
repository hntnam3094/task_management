<?php
namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\SendMail;
use App\Models\User;
use App\Validator\BaseValidator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Register;

class AuthController extends Controller
{

    public function changePassword (Request $request) {
        $email = $request->email;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;

        if (!$password || !$password_confirmation) {
            return response()->json(['message' => 'Please enter password and confirm password', 'code' => 422], 422);
        }

        if ($password != $password_confirmation) {
            return response()->json(['message' => 'Confirm password is incorrect', 'code' => 422], 422);
        }

        $user = User::query()->where('email', $email)->first();

        if ($user) {
            $data = [
              'password' => Hash::make($password)
            ];

            $user->update($data);

            return true;
        }

        return response()->json(['message' => 'Password change failed, please go through the process again', 'code' => 422], 422);
    }

    public function reVerify (Request $request) {
        $email = $request->email;

        $user = User::query()->where('email', $email)->first();

        if ($user) {
            if ($user->status == 1) {
                return response()->json(['message' => 'Verified email', 'code' => 422], 422);
            }

            $data = [
                'url' => env('FE_URL') . '/verify?token=' . md5($email)
            ];

            SendMail::dispatch('verify', $data, $user);

            return true;
        }
        return response()->json(['message' => 'Email doesn\'t exist', 'code' => 422], 422);

    }

    public function forgetPassword (Request $request) {
        $email = $request->email;

        $user = User::query()->where('email', $email)->first();

        if ($user) {

            $data = [
                'url' => env('FE_URL') . '/setup-password?email=' . $email
            ];

            SendMail::dispatch('forget-password', $data, $user);

            return true;
        }
        return response()->json(['message' => 'Email doesn\'t exist', 'code' => 422], 422);

    }

    public function register(RegisterRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'activeToken' => md5($request->email)
        ]);

        //create verify token
        $data = [
          'url' => env('FE_URL') . '/verify?token=' . md5($request->email)
        ];

        SendMail::dispatch('verify', $data, $user);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if ( Auth::user()->status == 1) {
                $token = $request->user()->createToken('auth_token')->plainTextToken;
                return response()->json(['token' => $token, 'user' => $request->user()]);
            }
            return response()->json(['message' => 'Please, Verify your email before login', 'code' => 422], 422);
        }

        return response()->json(['message' => 'Account password is incorrect', 'code' => 401], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    public function userList() {
        $result = User::query()->get();
        return $result;
    }

    public function verifyToken (Request $request) {
       $token = $request->token;

       if ($token) {
           $result = User::query()->where('activeToken', $token)->first();

           if ($result) {
               $data = [
                 'status' => 1,
                 'activeToken' => ''
               ];
               $result->update($data);
               return true;
           }
       }
       return false;
    }
}
