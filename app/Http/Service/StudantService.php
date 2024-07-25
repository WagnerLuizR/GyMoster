<?php

namespace App\Services;

use App\Repositories\StudentRepository;

class StudentService
{
    protected $repository;

    public function __construct(StudentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createStudent($data)
    {
        return $this->repository->create($data);
    }

    public function updateStudent($id, $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteStudent($id)
    {
        return $this->repository->delete($id);
    }

    public function findStudentById($id)
    {
        return $this->repository->findById($id);
    }

    public function findAllStudents()
    {
        return $this->repository->findAll();
    }
}
