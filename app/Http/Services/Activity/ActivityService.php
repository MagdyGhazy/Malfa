<?php

namespace App\Http\Services\Activity;

use App\Http\Traits\AttachmentTrait;
use App\Http\Traits\RepositoryTrait;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Builder;

class ActivityService
{
    use RepositoryTrait, AttachmentTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Activity();
    }

    public function index()
    {
        $search = request()->get('search');
        $perPage = request()->get('limit', 10);

        $parameters = [
            'select' => ['id', 'user_id', 'name_en', 'name_ar', 'from', 'to', 'price'],
            'relations' => ['user:id,name', 'address:id,model_id,model_type,address_line_en,address_line_ar,city_id,lat,long,zip_code',
                'features:id,name_en,name_ar,type',
                'reviews:id,user_id,model_id,model_type,rate,message'],
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
            'select' => ['id', 'user_id', 'name_en', 'name_ar', 'from', 'to', 'price'],
            'relations' => ['user:id,name', 'address:id,model_id,model_type,address_line_en,address_line_ar,city_id,lat,long,zip_code',
                'media:id,name,path,model_id,model_type',
                'features:id,name_en,name_ar,type',
                'reviews:id,user_id,model_id,model_type,rate,message'
            ],
        ];

        return $this->getOne($this->model, $id, $parameters);
    }

    public function store(array $request)
    {
        $addressData = $request['address'] ?? null;
        unset($request['address']);

        $activity = $this->create($this->model, $request);

        if ($addressData) {
            $activity->address()->create($addressData);
        }

        if (isset($request['images'])) {
            $this->addGroupMedia($activity, $request['images'], 'activities', 'activity_image');
        }

        return $activity;
    }

    public function update(array $request, int $id)
    {
        $activity = $this->edit($this->model, $request, $id);

        if (isset($request['address'])) {
            $addressData = $request['address'];
            $activity->address()->updateOrCreate([], $addressData);
        }

        if (isset($request['images'])) {
            $this->updateGroupMedia($activity, $request['images'], 'activities', 'activity_image');
        }

        return $activity;
    }

    public function destroy(int $id)
    {
        $activity = $this->model->findOrFail($id);
        $this->deleteMedia($activity);
        $activity->address()->delete();
        return $this->delete($this->model, $id);
    }

    protected function filter(Builder $query, $search)
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('name_ar', 'LIKE', "%{$search}%");
            $q->orWhere('name_en', 'LIKE', "%{$search}%");
            $q->orWhere('description_ar', 'LIKE', "%{$search}%");
            $q->orWhere('description_en', 'LIKE', "%{$search}%");
        });
    }
}
