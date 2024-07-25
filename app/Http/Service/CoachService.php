<?php

namespace App\Services;

use App\Repositories\CoachRepository;

class CoachService
{
    protected $repository;

    public function __construct(CoachRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createCoach($data)
    {
        return $this->repository->create($data);
    }

    public function updateCoach($id, $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteCoach($id)
    {
        return $this->repository->delete($id);
    }

    public function findCoachById($id)
    {
        return $this->repository->findById($id);
    }

    public function findAllCoachs()
    {
        return $this->repository->findAll();
    }
}
