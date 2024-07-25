<?php

namespace App\Services;

use App\Repositories\TrainingRepository;

class TrainingService
{
    protected $repository;

    public function __construct(TrainingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createTraining($data)
    {
        return $this->repository->create($data);
    }

    public function updateTraining($id, $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteTraining($id)
    {
        return $this->repository->delete($id);
    }

    public function findTrainingById($id)
    {
        return $this->repository->findById($id);
    }

    public function findAllTrainings()
    {
        return $this->repository->findAll();
    }
}
