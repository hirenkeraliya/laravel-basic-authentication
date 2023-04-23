<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Api\LoginValidation;
use App\Http\Requests\Api\RegisterValidation;
use App\Http\Resources\Api\UserResource;
use App\Mail\UserWelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController
{
    public function register(RegisterValidation $registerValidation)
    {
        $validatedData = $registerValidation->validated();
        $password = Str::random(10);
        $validatedData['password'] = bcrypt($password);

        $User = User::create($validatedData);

        Mail::to([[
            'name' => $User->name,
            'email' => $User->email,
        ]])->send(new UserWelcomeMail($User, $password));

        return [
            'status' => true,
            'user_details' => new UserResource($User)
        ];
    }

    public function login(LoginValidation $registerValidation)
    {
        $validatedData = $registerValidation->validated();

        $User = User::where('email', $validatedData['email'])->first();

        if (! $User) {
            return [
                'status' => false,
                'message' => 'User Not found in our records.',
            ];
        }

        if (! $User->status) {
            return [
                'status' => false,
                'message' => 'User is inactive.',
            ];
        }

        if (Hash::check($validatedData['password'], $User->password)) {
            $newAccessToken = $User->createToken('mobile-application');

            return [
                'user_details' => new UserResource($User),
                'token' => $newAccessToken->plainTextToken
            ];
        }

        return [
            'status' => false,
            'message' => 'User credentials not match with our records.',
        ];
    }

    public function getUserDetails(Request $request)
    {
        $User = $request->user();

        return [
            'user_details' => new UserResource($User),
        ];
    }

    public function logout(Request $request)
    {
        $User = $request->user();

        $User->tokens()->delete();
    }
}
