<?php

namespace App\Http\Services\Review;

use App\Http\Traits\RepositoryTrait;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;

class ReviewService
{
    use RepositoryTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Review();
    }

    public function index()
    {
        $search  = request()->get('search');
        $perPage = request()->get('limit', 10);

        $parameters = [
            'select'    => ['id','user_id','model_id','model_type','rate','message'],
            'relations' => ['user:id,name'],
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
            'select'    => ['id','user_id','model_id','model_type','rate','message'],
            'relations' => ['user:id,name','media:id,name,path,model_id,model_type'],
        ];

        return $this->getOne($this->model, $id, $parameters);
    }

    public function store(array $request)
    {
        $review = $this->create($this->model, $request);

        if (isset($request['images'])) {
            $this->addGroupMedia($review, $request['images'], 'reviews', 'review_image');
        }

        return $review;
    }

    public function update(array $request, int $id)
    {
        $review = $this->edit($this->model, $request, $id);

        if (isset($request['images'])) {
            $this->updateGroupMedia($review, $request['images'], 'reviews', 'review_image');
        }

        return $review;
    }

    public function destroy(int $id)
    {
        return $this->delete($this->model, $id);
    }

    protected function filter(Builder $query, $search)
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('id', 'LIKE', "%{$search}%");
            $q->orWhere('message', 'LIKE', "%{$search}%");
            $q->orWhere('rate', 'LIKE', "%{$search}%");
        });
    }
}
