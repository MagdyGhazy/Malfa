<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\StoreRestaurantRequest;
use App\Http\Requests\Restaurant\UpdateRestaurantRequest;
use App\Http\Requests\RestaurantTable\StoreRestaurantTableRequest;
use App\Http\Requests\RestaurantTable\UpdateRestaurantTableRequest;
use App\Http\Services\Restaurant\RestaurantService;
use App\Http\Traits\ResponseTrait;


class RestaurantController extends Controller
{
    use ResponseTrait;

    protected $service;
    protected string $key;

    public function __construct(RestaurantService $service)
    {
        $this->service = $service;
        $this->key = 'Restaurant';
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


    public function store(StoreRestaurantRequest $request)
    {
        $data = $this->service->store($request->validated());
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' created successfully') : $this->error(null, 404, 'Cannot create ' . $this->key, $data['error']);
    }


    public function update(UpdateRestaurantRequest $request, $id)
    {
       $data = $this->service->update($request->validated(), $id);
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' updated successfully') : $this->error(null, 404, 'Cannot update ' . $this->key, $data['error']);
    }


    public function destroy($id)
    {
        $data = $this->service->destroy($id);
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' deleted successfully') : $this->error(null, 404, 'Cannot delete ' . $this->key, $data['error']);
    }
    public function toggleStatus($id)
    {
        $data = $this->service->toggleStatus($id);
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' Status Changed successfully') : $this->error(null, 404, 'Cannot Change Status ' . $this->key, $data['error']);
    }
    public function storeTable(StoreRestaurantTableRequest $request)
    {
        $data = $this->service->storeTable($request->validated());
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' created successfully') : $this->error(null, 404, 'Cannot create ' . $this->key, $data['error']);
    }


    public function updateTable(UpdateRestaurantTableRequest $request, $id)
    {
        $data = $this->service->updateTable($request->validated(), $id);
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' updated successfully') : $this->error(null, 404, 'Cannot update ' . $this->key, $data['error']);
    }


    public function destroyTable($id)
    {
        $data = $this->service->destroyTable($id);
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' deleted successfully') : $this->error(null, 404, 'Cannot delete ' . $this->key, $data['error']);
    }
    public function toggleAvailable($id)
    {
        $data = $this->service->toggleAvailable($id);
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' Available Changed successfully') : $this->error(null, 404, 'Cannot Change Available ' . $this->key, $data['error']);
    }
}
