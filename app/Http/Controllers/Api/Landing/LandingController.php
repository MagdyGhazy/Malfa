<?php

namespace App\Http\Controllers\Api\Landing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Landing\StoreLandingRequest;
use App\Http\Requests\Landing\UpdateLandingRequest;
use App\Http\Services\Landing\LandingService;
use App\Http\Traits\ResponseTrait;


class LandingController extends Controller
{
    use ResponseTrait;

    protected $service;
    protected string $key;

    public function __construct(LandingService $service)
    {
        $this->service = $service;
        $this->key = 'Landing';
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


    public function store(StoreLandingRequest $request)
    {
        $data = $this->service->store($request->validated());
        return !isset($data['error']) ? $this->success($data, 201, $this->key . ' created successfully') : $this->error(null, 404, 'Cannot create ' . $this->key, $data['error']);
    }


    public function update(UpdateLandingRequest $request, $id)
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
