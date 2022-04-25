<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements IRepository
{
    /**      
     * @var Model      
     */
    protected $model;

    /**      
     * BaseRepository constructor.      
     *      
     * @param Model $model      
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function table(): Model
    {
        return $this->model;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $records
     * @return boolean
     */
    public function insert(array $records): bool
    {
        return $this->model->insert($records);
    }

    /**
     * @param array $attributes
     *
     * @return boolean
     */
    public function update(array $attributes): bool
    {
        return $this->model->update($attributes);
    }


    public function delete(): bool
    {
        return $this->model->delete();
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }
}
