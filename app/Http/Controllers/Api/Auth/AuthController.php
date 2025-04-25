<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\Auth\AuthService;
use App\Http\Traits\ResponseTrait;

class AuthController extends Controller
{
    use ResponseTrait;

    protected $service;
    protected string $key;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
        $this->key = 'User';
    }

    public function register(RegisterRequest $request)
    {
        $data = $this->service->register($request->validated());
        return $data ? $this->success($data, 201, $this->key . ' registered successfully') : $this->error(null, 404, 'Cannot register ' . $this->key);
    }

    public function login(LoginRequest $request)
    {
        $data = $this->service->login($request->validated());
        return $data && !isset($data['error']) ? $this->success($data, 200, $this->key . ' login successfully') : $this->error(null, 401, $data['error'] ?? 'Cannot login ' . $this->key);
    }


    public function logout()
    {
        $data = $this->service->logout();
        return $data ? $this->success(null, 200, $this->key . ' logged out successfully') : $this->error(null, 401, 'User not authenticated or token missing');
    }
}
