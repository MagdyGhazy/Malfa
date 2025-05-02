<?php

namespace App\Http\Traits;

trait RepositoryTrait
{
    private function buildQuery($query, $parameters = [])
    {
        try {

            $query->when(!empty($parameters['select']), function ($query) use ($parameters) {
                $query->select($parameters['select']);
            });

            $query->when(!empty($parameters['relations']), function ($query) use ($parameters) {
                $query->with($parameters['relations']);
            });

            $query->when(!empty($parameters['where']) && is_array($parameters['where']), function ($query) use ($parameters) {
                foreach ($parameters['where'] as $condition) {
                    if (is_array($condition) && count($condition) >= 2) {
                        $query->where(...$condition);
                    }
                }
            });

            $query->orderBy('created_at', 'desc');

            return $query;
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function query($model, array $parameters = [])
    {
        return $this->buildQuery($model->newQuery(), $parameters);
    }

    public function getAll($model, $parameters = [])
    {
        return $this->buildQuery($model->query(), $parameters)->get();
    }

    public function getOne($model, $id, $parameters = [])
    {
        $data = $model->find($id);

        if ($data) {
            return $this->buildQuery($model->query(), $parameters)->find($id);
        }

        return $data ?? ['error' => 'Data not exists'];

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
