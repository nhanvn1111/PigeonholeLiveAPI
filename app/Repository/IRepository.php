<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function table(): Model;

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model;

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param array $records
     * @return boolean
     */
    public function insert(array $records): bool;

    /**
     * @param array $attributes
     * 
     * @return boolean
     */
    public function update(array $attributes): bool;

    /** 
     * @return boolean
     */
    public function delete(): bool;
}
