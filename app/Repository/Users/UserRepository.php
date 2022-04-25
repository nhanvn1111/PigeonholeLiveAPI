<?php

namespace App\Repository\Users;

use App\Models\User;
use App\Repository\BaseRepository;

class UserRepository extends BaseRepository
{

    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }
}
