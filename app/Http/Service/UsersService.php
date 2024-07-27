<?php

namespace App\Services;

use App\Repositories\UsersRepository;

class UsersService
{
    protected $repository;

    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createUsers($data)
    {
        return $this->repository->create($data);
    }

    public function updateUsers($id, $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteUsers($id)
    {
        return $this->repository->delete($id);
    }

    public function findUsersById($id)
    {
        return $this->repository->findById($id);
    }

    public function findAllUserss()
    {
        return $this->repository->findAll();
    }
}
