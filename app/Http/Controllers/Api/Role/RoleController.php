<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdatePermissionRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Services\Role\RoleService;
use App\Http\Traits\ResponseTrait;


class RoleController extends Controller
{
    use ResponseTrait;

    protected $service;
    protected string $key;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
        $this->key = 'Role';
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


    public function store(StoreRoleRequest $request)
    {
        $data = $this->service->store($request->validated());
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' created successfully') : $this->error(null, 404, 'Cannot create ' . $this->key, $data['error']);
    }


    public function update(UpdateRoleRequest $request, $id)
    {
       $data = $this->service->update($request->validated(), $id);
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' updated successfully') : $this->error(null, 404, 'Cannot update ' . $this->key, $data['error']);
    }


    public function destroy($id)
    {
        $data = $this->service->destroy($id);
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' deleted successfully') : $this->error(null, 404, 'Cannot delete ' . $this->key, $data['error']);
    }

    public function allPermissions()
    {
        $data = $this->service->allPermissions();
        return !isset($data['error']) ? $this->success($data, 200, 'All Permissions') : $this->error(null, 404, 'Cannot fetch Permissions', $data['error']);
    }


    public function updatePermission(UpdatePermissionRequest $request, $id)
    {
        $data = $this->service->updatePermission($request->validated(), $id);
        return !isset($data['error']) ? $this->success($data, 201, 'Permission updated successfully') : $this->error(null, 404, 'Cannot update Permission', $data['error']);
    }
}
