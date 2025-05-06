<?php

namespace App\Http\Services\Feature;

use App\Http\Traits\RepositoryTrait;
use App\Models\Feature;
use Illuminate\Database\Eloquent\Builder;

class FeatureService
{
    use RepositoryTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Feature();
    }

    public function index()
    {
        $search = request()->get('search');
        $perPage = request()->get('limit', 10);

        $parameters = [
            'select' => ['id', 'name_en', 'name_ar', 'type'],
            'relations' => ['units:id,name'],
//            'where' => [
//                 ['status', '=', 'active'],
//            ]
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
            'select' => ['id', 'name_en', 'name_ar', 'type'],
            'relations' => ['units:id,name'],
//            'relations' => [],
//            'where' => [
//                 ['status', '=', 'active'],
//            ]
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
            $q->where('name_en', 'LIKE', "%{$search}%");
            $q->orWhere('name_ar', 'LIKE', "%{$search}%");
        });
    }
}
