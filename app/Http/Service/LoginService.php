<?php

namespace App\Services;

use App\Repositories\LoginRepository;

class LoginService
{
    protected $repository;

    public function __construct(LoginRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createLogin($data)
    {
        return $this->repository->create($data);
    }

    public function updateLogin($id, $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteLogin($id)
    {
        return $this->repository->delete($id);
    }

    public function findLoginById($id)
    {
        return $this->repository->findById($id);
    }

    public function findAllLogins()
    {
        return $this->repository->findAll();
    }
}
