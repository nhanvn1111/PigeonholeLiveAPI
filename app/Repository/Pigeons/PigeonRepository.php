<?php

namespace App\Repository\Pigeons;

use App\Models\Pigeon;
use App\Repository\BaseRepository;

class PigeonRepository extends BaseRepository
{

    protected $model;

    /**
     * PigoneRepository constructor.
     *
     * @param Pigeon $model
     */
    public function __construct(Pigeon $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }
}
