<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Api\LoginValidation;
use App\Http\Requests\Api\RegisterValidation;
use App\Http\Resources\Api\SecondUserResource;
use App\Models\SecondUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SecondUserController
{
    public function register(RegisterValidation $registerValidation)
    {
        $validatedData = $registerValidation->validated();
        $password = Str::random(10);
        info($password);
        $validatedData['password'] = bcrypt($password);

        $secondUser = SecondUser::create($validatedData);

        return [
            'status' => true,
            'user_details' => new SecondUserResource($secondUser)
        ];
    }

    public function login(LoginValidation $registerValidation)
    {
        $validatedData = $registerValidation->validated();

        $secondUser = SecondUser::where('email', $validatedData['email'])->first();

        if (! $secondUser) {
            return [
                'status' => false,
                'message' => 'User Not found in our records.',
            ];
        }

        if (! $secondUser->status) {
            return [
                'status' => false,
                'message' => 'User is inactive.',
            ];
        }

        if (Hash::check($validatedData['password'], $secondUser->password)) {
            $newAccessToken = $secondUser->createToken('mobile-application');

            return [
                'user_details' => new SecondUserResource($secondUser),
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
        $secondUser = $request->user();

        return [
            'user_details' => new SecondUserResource($secondUser),
        ];
    }

    public function logout(Request $request)
    {
        $secondUser = $request->user();

        $secondUser->tokens()->delete();
    }
}
