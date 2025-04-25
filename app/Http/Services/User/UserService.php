<?php

namespace App\Http\Services\User;

use App\Http\Traits\AttachmentTrait;
use App\Http\Traits\RepositoryTrait;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserService
{
    use RepositoryTrait,AttachmentTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        $search  = request()->get('search');
        $perPage = request()->get('limit', 10);

        $parameters = [
            'select' => ['id', 'name', 'email', 'phone', 'type'],
            'relations' => ['roles:id,name_en,name_ar','media:id,name,path,model_id,model_type'],
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
            'select' => ['id', 'name', 'email', 'phone', 'type'],
            'relations' => ['roles:id,name_en,name_ar','media:id,name,path,model_id,model_type'],
        ];

        return $this->getOne($this->model, $id, $parameters);
    }

    public function store(array $request)
    {
        $data = $this->create($this->model, $request);

        $data->assignRole($request['role_id']);

        if (isset($request['image'])) {
            $this->addMedia($data, $request['image'], 'users', 'profile_image');
        }

        return $data;
    }

    public function update(array $request, int $id)
    {
        $data = $this->edit($this->model, $request, $id);

        $data->assignRole($request['role_id']);

        if (isset($request['image'])) {

            $media = $data->media()->where('name', 'profile_image')->first();

            if ($media) {
                $this->updateMedia($data, $media->id, $request['image'], 'users', 'profile_image');
            } else {
                $this->addMedia($data, $request['image'], 'users', 'profile_image');
            }
        }

        return $data;
    }

    public function destroy(int $id)
    {
        return $this->delete($this->model, $id);
    }

    protected function filter(Builder $query, $search)
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%");
        });
    }
}
