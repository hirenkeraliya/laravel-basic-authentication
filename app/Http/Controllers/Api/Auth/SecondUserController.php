<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Api\RegisterValidation;
use App\Http\Resources\Api\RegisterResource;
use App\Models\SecondUser;
use Illuminate\Support\Str;

class SecondUserController
{
    public function register(RegisterValidation $registerValidation)
    {
        $validatedData = $registerValidation->validated();
        $password = Str::random(10);
        $validatedData['password'] = bcrypt($password);

        $secondUser = SecondUser::create($validatedData);

        return [
            'user_details' => new RegisterResource($secondUser)
        ];
    }
}
