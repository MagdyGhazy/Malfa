<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\User\UserService;
use App\Http\Traits\ResponseTrait;


class UserController extends Controller
{
    use ResponseTrait;

    protected $service;
    protected string $key;

    public function __construct(UserService $service)
    {
        $this->service = $service;
        $this->key = 'User';
    }


    public function index()
    {
        $data = $this->service->index();
        return !isset($data['error']) ? $this->success($data, 200, 'All ' . $this->key . 's') : $this->error(null, 404, 'Cannot fetch ' . $this->key . 's', $data['error']);
    }


    public function show($id)
    {
        $data = $this->service->show($id);
        return !isset($data['error']) ? $this->success($data, 200, $this->key . ' details') : $this->error(null, 404, 'Cannot fetch ' . $this->key, $data['error']);
    }


    public function store(StoreUserRequest $request)
    {
        $data = $this->service->store($request->validated());
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' created successfully') : $this->error(null, 404, 'Cannot create ' . $this->key, $data['error']);
    }


    public function update(UpdateUserRequest $request, $id)
    {
       $data = $this->service->update($request->validated(), $id);
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' updated successfully') : $this->error(null, 404, 'Cannot update ' . $this->key, $data['error']);
    }


    public function destroy($id)
    {
        $data = $this->service->destroy($id);
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' deleted successfully') : $this->error(null, 404, 'Cannot delete ' . $this->key, $data['error']);
    }
}
