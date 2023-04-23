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

        $user = User::create($validatedData);

        Mail::to([[
            'name' => $user->name,
            'email' => $user->email,
        ]])->send(new UserWelcomeMail($user, $password));

        return [
            'status' => true,
            'user_details' => new UserResource($user)
        ];
    }

    public function login(LoginValidation $registerValidation)
    {
        $validatedData = $registerValidation->validated();

        $user = User::where('email', $validatedData['email'])->first();

        if (! $user) {
            return [
                'status' => false,
                'message' => 'User Not found in our records.',
            ];
        }

        if (! $user->status) {
            return [
                'status' => false,
                'message' => 'User is inactive.',
            ];
        }

        if (Hash::check($validatedData['password'], $user->password)) {
            $newAccessToken = $user->createToken('mobile-application');

            return [
                'user_details' => new UserResource($user),
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
        $user = $request->user();

        return [
            'user_details' => new UserResource($user),
        ];
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->tokens()->delete();
    }
}
