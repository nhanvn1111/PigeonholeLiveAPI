<?php

namespace App\Repository\Orders;

use App\Models\Order;
use App\Repository\BaseRepository;

class OrderRepository extends BaseRepository
{

    protected $model;

    /**
     * OrderRepository constructor.
     *
     * @param Order $model
     */
    public function __construct(Order $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }
}
