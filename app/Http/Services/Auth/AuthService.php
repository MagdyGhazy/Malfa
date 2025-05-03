<?php

namespace App\Http\Services\Auth;

use App\Http\Enums\UserTypeEnum;
use App\Http\Traits\RepositoryTrait;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use RepositoryTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function register($request)
    {
        $request['password'] = Hash::make($request['password']);
        $request['type']     = UserTypeEnum::from((int) $request['type'])->value;
        $user = $this->create($this->model, $request);

        $user->assignRole(3);

        $token = $user->createToken('auth_token')->plainTextToken;

        if ($token && $user){
            return  [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ];
        }

        return false;
    }


    public function login($request)
    {
        $key = isset($request['phone']) ? 'phone' : 'email';

        $parameters = [
            'select'    => ['id','name','phone','type', 'password', 'email_verified_at'],
            'where'     => [[$key, '=', $request[$key]]],
        ];

        $user = $this->query($this->model, $parameters)->first();


        if (!$user) {
            return ['error' => 'wrong phone or email'];
        }

        if ($user->email_verified_at == null) {
            return ['error' => 'you must verify your email'];
        }

        if (!Hash::check($request['password'], $user->password)) {
            return ['error' => 'wrong password'];
        }

        $user->permissions = $user->getPermissions();
        $token             = $user->createToken('auth_token')->plainTextToken;

        unset($user->roles);

        if ($token && $user){
            return  [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ];
        }

        return false;
    }

    public function logout()
    {
        $user = auth()->user();

        if ($user && method_exists($user, 'currentAccessToken')) {
            $user->currentAccessToken()->delete();
            return true;
        }

        return false;
    }


}
