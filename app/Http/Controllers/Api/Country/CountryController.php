<?php

namespace App\Http\Controllers\Api\Country;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Http\Services\Country\CountryService;
use App\Http\Traits\ResponseTrait;

class CountryController extends Controller
{
    use ResponseTrait;

    protected $service;
    protected string $key;

    public function __construct(CountryService $service)
    {
        $this->service = $service;
        $this->key = 'Country';
        $this->Secondkey = 'State';
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
    public  function getCities($id)
    {
        $data =$this->service->getCities($id);
        return !isset($data['error']) ? $this->success($data, 200, $this->Secondkey . ' details') : $this->error(null, 404, 'Cannot fetch ' . $this->Secondkey, $data['error']);
    }

}
