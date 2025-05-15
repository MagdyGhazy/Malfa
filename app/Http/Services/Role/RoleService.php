<?php

namespace App\Http\Services\Role;

use App\Http\Traits\RepositoryTrait;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class RoleService
{
    use RepositoryTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Role();
    }

    public function index()
    {
        $search = request()->get('search');
        $perPage = request()->get('limit', 10);

        $parameters = [
            'select'    => ['id','name_en','name_ar'],
        ];

        $query = $this->query($this->model, $parameters);

        if ($search) {
            $query = $this->filter($query, $search);
        }

        $data = $query->paginate($perPage);
        return $data ?? null;
    }


    public function show(int $id)
    {
        $parameters = [
            'select'    => ['id','name_en','name_ar'],
            'relations' => ['permissions:id,name,description'],
        ];

        $data = $this->getOne($this->model, $id, $parameters);
        return $data ?? null;
    }


    public function store(array $request)
    {
        $role = $this->create($this->model, $request);
        $role->permissions()->sync($request['permissions']);
        return $role;
    }


    public function update(array $request, int $id)
    {
        $role = $this->edit($this->model, $request, $id);
        $role->permissions()->sync($request['permissions']);
        return $role;
    }


    public function destroy(int $id)
    {
        return $this->delete($this->model, $id);
    }


    public function allPermissions()
    {
        $search = request()->get('search');

        $parameters = [
            'select'    => ['id', 'name', 'description'],
        ];

        $query = $this->query(new Permission(), $parameters);

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $data = $query->get()->groupBy(function ($permission) {
            $name = Str::of($permission->name)->after(' ');
            return __('translate.' . $name) ?? null;
        });

        return $data ?? null;
    }



    public function updatePermission(array $request, int $id)
    {
        return $this->edit(new Permission(), $request, $id);
    }

    protected function filter(Builder $query, $search)
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('name_en', 'LIKE', "%{$search}%");
             $q->orWhere('name_ar', 'LIKE', "%{$search}%");
        });
    }
}
