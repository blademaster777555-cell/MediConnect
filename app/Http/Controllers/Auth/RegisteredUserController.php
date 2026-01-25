<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    protected $userService;

    public function __construct(\App\Services\UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(\App\Http\Requests\Auth\RegisterUserRequest $request): RedirectResponse
    {
        $user = $this->userService->register($request->validated());

        Auth::login($user);

        if ($user->role === User::ROLE_DOCTOR) {
            $admins = User::where('role', User::ROLE_ADMIN)->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\NewDoctorRegistered($user));
            }
        }

        return redirect(route('dashboard', absolute: false));
    }
}
