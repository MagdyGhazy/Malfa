<?php

namespace App\Http\Services\Unit;

use App\Http\Services\Address\AddressService;
use App\Http\Traits\AttachmentTrait;
use App\Http\Traits\RepositoryTrait;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Builder;

class UnitService
{
    use RepositoryTrait, AttachmentTrait;

    protected $model;

    public function __construct(AddressService $addressService)
    {
        $this->model = new Unit();
        $this->addressService = $addressService;
    }

    public function index()
    {
        $search = request()->get('search');
        $perPage = request()->get('limit', 10);

        $parameters = [
            'select' => ['id', 'name', 'description_en', 'description_ar', 'status', 'type', 'rating', 'available_rooms', 'user_id'],
            'relations' => ['user:id,name', 'address', 'media:id,name,path,model_id,model_type'],
            'where' => [
                ['status', '=', '1'],
            ]
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
            'select' => ['id', 'name', 'description_en', 'description_ar', 'type', 'rating', 'available_rooms', 'user_id', 'status'],
            'relations' => ['user:id,name', 'address', 'media:id,name,path,model_id,model_type'],
            'where' => [
                ['status', '=', '1'],
            ]
        ];

        return $this->getOne($this->model, $id, $parameters);
    }

    public function store(array $request)
    {
        $addressData = $request['address'] ?? null;
        unset($request['address']);
        $unit = $this->create($this->model, $request);

        if ($unit && $addressData) {
            $addressData['model_id'] = $unit->id;
            $addressData['model_type'] = get_class($this->model);
            $this->addressService->store($addressData);
        }

        if (isset($request['images'])) {
            $this->addGroupMedia($unit, $request['images'], 'units', 'unit_images');
        }

        return $unit;
    }

    public function update(array $request, int $id)
    {
        $data = $this->model->findOrFail($id);
        if (isset($request['address'])) {
            $addressData = $request['address'];
            $this->addressService->update($addressData, $data->address->id);
        }

        if (isset($request['images'])) {
            $media = $data->media()->where('name', 'unit_images')->first();
            if ($media) {
                $this->updateGroupMedia($data, $request['images'], 'units', 'unit_images');
            } else {
                $this->addMedia($data, $request['images'], 'units', 'unit_images');
            }
        }
        return $this->edit($data, $request, $id);
    }

    public function destroy(int $id)
    {

        $data = $this->model->find($id);
        if ($data->address) {
            $this->addressService->destroy($data->address->id);
        }
        if ($data->media) {
            foreach ($data->media as $media) {
                $media->delete();
            }
        }
        return $this->delete($this->model, $id);

    }

    protected function filter(Builder $query, $search)
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('description_en', 'LIKE', "%{$search}%");
            $q->orWhere('description_ar', 'LIKE', "%{$search}%");
            $q->orWhere('rating', 'LIKE', "%{$search}%");
            $q->orWhere('type', 'LIKE', "%{$search}%");
            $q->orWhere('name', 'LIKE', "%{$search}%");
        });
    }
}
