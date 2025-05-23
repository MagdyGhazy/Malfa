<?php

namespace App\Http\Services\Unit;

use App\Http\Enums\StatusEnum;
use App\Http\Services\Address\AddressService;
use App\Http\Traits\AttachmentTrait;
use App\Http\Traits\RepositoryTrait;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Builder;

class UnitService
{
    use RepositoryTrait, AttachmentTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Unit();
    }

    public function index()
    {
        $search = request()->get('search');
        $perPage = request()->get('limit', 10);

        $parameters = [
            'select' => ['id', 'name', 'description_en', 'description_ar', 'status', 'type', 'rating', 'available_rooms', 'user_id'],
            'relations' => ['user:id,name', 'address:id,model_id,model_type,address_line_en,address_line_ar,city_id,lat,long,zip_code',],
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
            'relations' => ['user:id,name',
                'address:id,model_id,model_type,address_line_en,address_line_ar,city_id,lat,long,zip_code',
                'media:id,name,path,model_id,model_type' ,
                'rooms:id,unit_id,room_type,price_per_night,capacity,description_en,description_ar,rules_en,rules_ar,is_available',
                'features:id,name_en,name_ar',
                'reviews:id,user_id,model_id,model_type,rate,message',
                'reviews.user:id,name',
            ],
        ];

        return $this->getOne($this->model, $id, $parameters);
    }

    public function store(array $request)
    {
        $addressData = $request['address'] ?? null;
        unset($request['address']);
        $data = $this->create($this->model, $request);
        $data->address()->create($addressData);
        if (isset($request['images'])) {
            $this->addGroupMedia($data, $request['images'], 'units', 'unit_image');
        }
        $featureIds = $request['features'] ?? [];
        unset($request['features']);

        if (!empty($featureIds)) {
            $data->features()->sync($featureIds);
        }

        return $data;
    }

    public function update(array $request, int $id)
    {
        $data = $this->edit($this->model, $request, $id);

        if (isset($request['address'])) {
            $addressData = $request['address'];
            $data->address()->update($addressData);
        }

        if (isset($request['images'])) {
            $this->updateGroupMedia($data, $request['images'], 'units', 'unit_image');
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
            $q->orWhere('rating', 'LIKE', "%{$search}%");
            $q->orWhere('name', 'LIKE', "%{$search}%");
        });
    }

    public  function toggleStatus(int $id)
    {
        $parameters = [
            'select'    => ['id','status'],
            'where'     => [
                ['id', '=', $id],
            ]
        ];
        $data = $this->query($this->model, $parameters)->first();
        $newStatus = $data->status == StatusEnum::ACTIVE->value
            ? StatusEnum::INACTIVE->value
            : StatusEnum::ACTIVE->value;
        return $this->edit($this->model,['status' => $newStatus], $id);
    }

}
