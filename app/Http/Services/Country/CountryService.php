<?php

namespace App\Http\Services\Country;

use App\Http\Traits\RepositoryTrait;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Eloquent\Builder;

class CountryService
{
    use RepositoryTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Country();
        $this->secondModel = new State();
    }

    public function index()
    {
        $search  = request()->get('search');
        $parameters = [
            'select'    => ['id','name_en','name_ar','iso_code'],
        ];

        $query = $this->query($this->model, $parameters);

        if ($search) {
            $query = $this->filter($query, $search);
        }

        return $query;
    }

    public function show(int $id)
    {
        $parameters = [
            'select'    => ['id','name','native'],
                'relations' => ['states'],
            ];
        return $this->getOne($this->model, $id, $parameters);
    }
    public  function getCities(int $id)
    {
        $parameters = [
            'select'    => ['id','name'],
            'relations' => ['cities'],
        ];

        return $this->getOne($this->secondModel, $id, $parameters);
    }



    protected function filter(Builder $query, $search)
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('native', 'LIKE', "%{$search}%");
            $q->orWhere('name', 'LIKE', "%{$search}%");
        });
    }
}
