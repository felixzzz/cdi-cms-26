<?php

namespace App\Actions;

use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(UserRequest $request){
        $data = [
            ...$request->only(['name', 'email', 'role_id', 'status']),
            'password' => Hash::make($request->password),
            'profile' => asset('assets/images/avatar.jpg')
        ];
        return User::create($data);
    }

    public function update(UserUpdateRequest $request, $ulid){
        $data = [
            ...$request->only(['name', 'email', 'role_id', 'status']),
            'profile' => asset('assets/images/avatar.jpg')
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        return User::where('ulid', $ulid)->update($data);
    }

    public function delete($ulid){
        return User::where('ulid', $ulid)->delete();
    }
}
