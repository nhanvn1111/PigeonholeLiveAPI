<?php

namespace App\Services\Orders;

use App\Repository\Orders\OrderRepository;
use App\Repository\Pigeons\PigeonRepository;
use Carbon\Carbon;
use App\Models\Pigeon;
class OrderService
{
    protected $oderRepository;
    protected $pigeonRepository;
    public function __construct(OrderRepository $oderRepository, PigeonRepository $pigeonRepository) {
        $this->oderRepository = $oderRepository;
        $this->pigeonRepository = $pigeonRepository;
    }


    public function getAll($page = 1, $pageSize = 15)
    {
        return $this->oderRepository->table()->paginate(perPage: $pageSize, page: $page);
    }

    /**
     * Get user by id
     * 
     * @param bigint id
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this->oderRepository->find(id: $id);
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes)
    {
        return $this->oderRepository->create($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function update(array $attributes)
    {
        return $this->oderRepository->update($attributes);
    }

    public function delete($id)
    {
        return $this->oderRepository->delete($id);
    }

    /**
     * function update status all Pigone
     * status = 1 when finish delivery
     */
    public function updateStatus(){
        $current = Carbon::now();
        $oderAll = $this->oderRepository->table()
                ->where('time_end_downtime','>',$current)
                ->get();
        if(!empty($oderAll)){
            foreach($oderAll as $orderItem){
                $pigoneItem = $this->pigeonRepository->find($orderItem->pigeonId);
                if(!empty($pigoneItem)){
                    $pigoneItem->status = Pigeon::STATUS_BUSY;
                    $pigoneItem->save();
                }
            }
        }
    }
}