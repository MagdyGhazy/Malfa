<?php

namespace App\Http\Services\Address;

use App\Http\Traits\RepositoryTrait;
use App\Models\Address;
use Illuminate\Database\Eloquent\Builder;

class AddressService
{
    use RepositoryTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Address();
    }

    public function index()
    {
        $search = request()->get('search');
        $perPage = request()->get('limit', 10);

        $parameters = [
            'select' => ['id', 'address_line_en', 'address_line_ar', 'zip_code', 'lat', 'long', 'city_id'],
            'relations' => ['city:id,name,country_id,state_id', 'city.state:id,name', 'city.country:id,name,native,iso_code'],
        ];

        $query = $this->query($this->model, $parameters);

        if ($search) {
            $query = $this->filter($query, $search);
        }

        return $query->paginate($perPage);
    }

    public function show(int $id)
    {
        $parameters = [
            'select' => ['id', 'address_line_en', 'address_line_ar', 'zip_code', 'lat', 'long', 'city_id'],
            'relations' => ['city:id,name,country_id,state_id', 'city.state:id,name', 'city.country:id,name,native,iso_code'],
        ];

        return $this->getOne($this->model, $id, $parameters);
    }

    public function store(array $request)
    {
        return $this->create($this->model, $request);
    }

    public function update(array $request, int $id)
    {
        return $this->edit($this->model, $request, $id);
    }

    public function destroy(int $id)
    {
        return $this->delete($this->model, $id);
    }

    protected function filter(Builder $query, $search)
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('address_line_en', 'LIKE', "%{$search}%");
            $q->orWhere('address_line_ar', 'LIKE', "%{$search}%");
            $q->orWhere('zip_code', 'LIKE', "%{$search}%");
        });
    }
}
