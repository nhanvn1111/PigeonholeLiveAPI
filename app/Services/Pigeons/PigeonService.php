<?php

namespace App\Services\Pigeons;

use App\Repository\Pigeons\PigeonRepository;


class PigeonService
{
    protected $pigeonRepository;
    public const PIGEONE_AVAILABLE = 0;
    public const PIGEONE_BUSY = 1;

    public function __construct(PigeonRepository $pigeonRepository) {
        $this->pigeonRepository = $pigeonRepository;
    }

    public function getAll($page = 1, $pageSize = 15)
    {
        return $this->pigeonRepository->table()
        ->join("loans", "loans.id", "repayments.loan_id")
        ->select(
            "repayments.id",
            "repayments.amount",
            "repayments.message",
            "repayments.loan_id",
            "repayments.created_at",
            "repayments.updated_at",
            "users.name",
        )
        ->paginate(perPage: $pageSize, page: $page);
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
        return $this->pigeonRepository->find(id: $id);
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes)
    {
        return $this->pigeonRepository->create($attributes);;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function update(array $attributes)
    {
        return $this->pigeonRepository->update($attributes);
    }

    public function delete($id)
    {
        return $this->pigeonRepository->delete($id);
    }

    public function getPigeoneWithStatus($status){
        $pigeones = $this->pigeonRepository->table()
                ->where('status',$status)
                ->get();
            return $pigeones;
    }
}