<?php

namespace App\Http\Services\Restaurant;

use App\Http\Enums\StatusEnum;
use App\Http\Traits\AttachmentTrait;
use App\Http\Traits\RepositoryTrait;
use App\Models\Restaurant;
use App\Models\RestaurantTable;
use Illuminate\Database\Eloquent\Builder;

class RestaurantService
{
    use RepositoryTrait,AttachmentTrait;

    protected $model;
    protected $model2;

    public function __construct()
    {
        $this->model = new Restaurant();
        $this->model2= new RestaurantTable();
    }

    public function index()
    {
        $search = request()->get('search');
        $perPage = request()->get('limit', 10);

        $parameters = [
            'select' => ['id', 'user_id', 'name', 'description_en', 'description_ar', 'rating', 'opening_time', 'closing_time', 'available_tables'],
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
            'select' => ['id', 'user_id', 'name', 'description_en', 'description_ar', 'rating', 'opening_time', 'closing_time', 'available_tables','status'],
            'relations' => [
                'user:id,name',
                'address:id,model_id,model_type,address_line_en,address_line_ar,city_id,lat,long,zip_code',
                'media:id,name,path,model_id,model_type',
                'features:id,name_en,name_ar',
                'tables:id,restaurant_id,capacity,description_en,description_ar,is_available',
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
            $this->addGroupMedia($data, $request['images'], 'restaurants', 'restaurant_image');
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

        $data= $this->edit($this->model, $request, $id);
        if (isset($request['address'])) {
            $addressData = $request['address'];
            $data->address()->update($addressData);
        }

        if (isset($request['images'])) {
            $this->updateGroupMedia($data, $request['images'], 'restaurants', 'restaurant_image');
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
    public function storeTable(array $request)
    {

        $data = $this->create($this->model2, $request);
        if (isset($request['images'])) {
            $this->addGroupMedia($data, $request['images'], 'restaurant_tables', 'restaurant_table_image');
        }
        if (isset($request['features'])) {
            $featureIds = $request['features'];
            $data->features()->sync($featureIds);
        }
        return $data;

    }
    public function updateTable(array $request, int $id)
    {
        $data = $this->edit($this->model2, $request, $id);
        if (isset($request['images'])) {
            $this->updateGroupMedia($data, $request['images'], 'restaurant_tables', 'restaurant_table_image');
        }
        if (isset($request['features'])) {
            $featureIds = $request['features'];
            $data->features()->sync($featureIds);
        }
        return $data;
    }
    public function destroyTable(int $id)
    {
        return $this->delete($this->model2, $id);
    }
    public function toggleAvailable(int $id)
    {
        $parameters = [
            'select' => ['id', 'is_available'],
            'where' => [
                ['id', '=', $id],
            ]
        ];
        $data = $this->query($this->model2, $parameters)->first();
        $newStatus = $data->is_available == 1 ? 2 : 1;
        return $this->edit($this->model2, ['is_available'=>$newStatus], $id);
    }


}
