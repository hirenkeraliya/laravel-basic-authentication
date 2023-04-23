<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\SecondUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SecondUserController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(): View
    {
        $secondUsers = SecondUser::get();

        return view('second_users.index', compact('secondUsers'));
    }
}
