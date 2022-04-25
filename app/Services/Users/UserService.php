<?php

namespace App\Services\Users;

use App\Repository\Users\UserRepository;


class UserService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->table();
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
        return $this->userRepository->find(id: $id);
    }

    /**
     * Get user by email
     * 
     * @param string email
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByEmail($email)
    {
        return $this->userRepository->table()->where('email', '=', $email)->firstOrFail();
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes)
    {
        return $this->userRepository->create($attributes);;
    }
}