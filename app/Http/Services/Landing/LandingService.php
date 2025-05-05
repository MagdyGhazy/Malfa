<?php

namespace App\Http\Services\Landing;

use App\Http\Traits\RepositoryTrait;
use App\Models\Landing;
use Illuminate\Database\Eloquent\Builder;

class LandingService
{
    use RepositoryTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Landing();
    }

    public function index()
    {
        $search  = request()->get('search');
        $perPage = request()->get('limit', 10);

        $parameters = [
            'select'    => ['id','description_en','description_ar'],
        ];

        $query = $this->query($this->model, $parameters);

        return $query->paginate($perPage);
    }

    public function show(int $id)
    {
        $parameters = [
            'select'    => ['id','description_en','description_ar'],
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
            $q->where('description_en', 'LIKE', "%{$search}%");
            $q->orWhere('description_ar', 'LIKE', "%{$search}%");
        });
    }
}
