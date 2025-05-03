<?php

namespace App\Http\Services\Country;

use App\Http\Traits\RepositoryTrait;
use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;

class CountryService
{
    use RepositoryTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Country();
    }

    public function index()
    {
        $search  = request()->get('search');
        $perPage = request()->get('limit', 10);

        $parameters = [
            'select'    => ['id','name_en','name_ar','iso_code'],
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
            'select'    => ['id','name_en','name_ar',],
                'relations' => ['cities'],
            ];

        return $this->getOne($this->model, $id, $parameters);
    }



    protected function filter(Builder $query, $search)
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('id', 'LIKE', "%{$search}%");
            // $q->orWhere('name', 'LIKE', "%{$search}%");
        });
    }
}
