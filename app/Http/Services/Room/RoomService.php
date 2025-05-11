<?php

namespace App\Http\Services\Room;

use App\Http\Enums\AvailableEnum;
use App\Http\Enums\StatusEnum;
use App\Http\Traits\AttachmentTrait;
use App\Http\Traits\RepositoryTrait;
use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;

class RoomService
{
    use RepositoryTrait, AttachmentTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Room();
    }

    public function index()
    {
        $search = request()->get('search');
        $perPage = request()->get('limit', 10);

        $parameters = [
            'select' => ['id', 'unit_id', 'room_type', 'price_per_night', 'capacity', 'description_en', 'description_ar', 'rules_en', 'rules_ar', 'is_available'],
            'relations' => ['unit:id,name,description_en,description_ar,status,type'],
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
                'select' => ['id', 'unit_id', 'room_type', 'price_per_night', 'capacity', 'description_en', 'description_ar', 'rules_en', 'rules_ar', 'is_available'],
                'relations' => [
                    'media:id,name,path,model_id,model_type',
                    'unit:id,name,description_en,description_ar,status,type',
                    'features:id,name_en,name_ar'
                ],
            ];
            return $this->getOne($this->model, $id, $parameters);
        }

    public function store(array $request)
    {
        $data = $this->create($this->model, $request);
        if (isset($request['images'])) {
            $this->addGroupMedia($data, $request['images'], 'rooms', 'room_image');
        }
        if (isset($request['features'])) {
            $featureIds = $request['features'];
            $data->features()->sync($featureIds);
        }
        return $data;

    }

    public function update(array $request, int $id)
    {
        $data = $this->edit($this->model, $request, $id);
        if (isset($request['images'])) {
            $this->updateGroupMedia($data, $request['images'], 'rooms', 'room_image');
        }
        if (isset($request['features'])) {
            $featureIds = $request['features'];
            $data->features()->sync($featureIds);
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
            $q->where('description_en', 'LIKE', "%{$search}%");
            $q->orWhere('description_ar', 'LIKE', "%{$search}%");
            $q->orWhere('rules_en', 'LIKE', "%{$search}%");
            $q->orWhere('rules_ar', 'LIKE', "%{$search}%");
        });
    }

        public function toggleAvailable(int $id)
        {
            $parameters = [
                'select' => ['id', 'is_available'],
                'where' => [
                    ['id', '=', $id],
                ]
            ];
            $data = $this->query($this->model, $parameters)->first();
            $newStatus = $data->is_available == 1 ? 2 : 1;
            return $this->edit($this->model, ['is_available'=>$newStatus], $id);
        }
}
