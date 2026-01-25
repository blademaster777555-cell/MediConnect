<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserService
{
    /**
     * Register a new user and create their corresponding profile.
     */
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'city_id' => $data['city_id'],
            'status' => 'active',
        ]);

        $this->createProfileForUser($user, $data);

        event(new Registered($user));

        return $user;
    }

    private function createProfileForUser(User $user, array $data): void
    {
        if ($user->role === User::ROLE_DOCTOR) {
            $user->doctorProfile()->create([
                'phone' => $data['phone'],
                'city_id' => $data['city_id'],
                'bio' => 'Chưa cập nhật tiểu sử',
            ]);
        } else {
            $user->patientProfile()->create([
                'phone' => $data['phone'],
                'address' => $data['address'],
            ]);
        }
    }
}
