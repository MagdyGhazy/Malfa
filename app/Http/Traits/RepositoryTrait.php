<?php

namespace App\Http\Traits;

trait RepositoryTrait
{
    private function buildQuery($query, $parameters = [])
    {
        try {
            $query->when($parameters['select'] ?? null, fn($query, $select) => $query->select($select))
                ->when($parameters['relations'] ?? null, fn($query, $relations) => $query->with($relations))
                ->when($parameters['where'] ?? null, fn($query) => $query->where(...$parameters['where']))
                ->when($parameters['where2'] ?? null, fn($query) => $query->where(...$parameters['where2']))
                ->when($parameters['where3'] ?? null, fn($query) => $query->where(...$parameters['where3']))
                ->orderBy('updated_at', 'desc');

            return $query;
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function query($model, $parameters = [])
    {
        try {
            return $this->buildQuery($model->query(), $parameters);
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getAll($model, $parameters = [])
    {
        try {
            return $this->buildQuery($model->query(), $parameters)->get();
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getOne($model, $id, $parameters = [])
    {
        try {
            $data = $model->find($id);

            if ($data) {
                return $this->buildQuery($model->query(), $parameters)->find($id);
            }

            return $data ?? ['error' => 'Data not exists'];
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }

    }

    public function create($model, $request)
    {
        try {
            return $model->create($request);
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function edit($model, $request, $id)
    {
        try {
            $data = $model->find($id);

            if ($data) {
                $data->update($request);
            }

            return $data ?? ['error' => 'Data not exists'];
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function delete($model, $id)
    {
        try {
            $data = $model->find($id);

            if ($data) {
                return $model->destroy($id);
            }

            return $data ?? ['error' => 'Data not exists'];
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
