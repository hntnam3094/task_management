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

    public function register(RegisterRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'activeToken' => md5($request->email)
        ]);

        $data = [
          'url' => env('FE_URL') . '/verify?token=' . md5($request->email)
        ];

        SendMail::dispatch('verify', $data, $user);

        // Tạo token Sanctum cho user đăng ký
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
            return response()->json(['error' => ['err' => 'Please, Verify your email before login'], 'code' => 422], 422);
        }

        return response()->json(['error' => 'Unauthorized', 'code' => 401], 401);
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

    public function sendEmailTest()
    {
        $email = 'hntnam98@gmail.com'; // Địa chỉ email bạn muốn gửi thử

        $data = [
            'subject' => 'Test Email',
            'body' => 'This is a test email.'
        ];

        Mail::raw($data['body'], function ($message) use ($email, $data) {
            $message->to($email)
                ->subject($data['subject']);
        });

        return response()->json(['message' => 'Test email sent']);
    }
}
