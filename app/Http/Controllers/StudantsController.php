<?php

namespace App\Http\Controllers;

use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $service;

    public function __construct(StudentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $students = $this->service->findAllStudents();
        return response()->json($students);
    }

    public function show($id)
    {
        $student = $this->service->findStudentById($id);
        return response()->json($student);
    }

    public function store(Request $request)
    {
        $studentId = $this->service->createStudent($request->all());
        $student = $this->service->findStudentById($studentId);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $this->service->updateStudent($id, $request->all());
        $student = $this->service->findStudentById($id);
        return response()->json($student);
    }

    public function destroy($id)
    {
        $this->service->deleteStudent($id);
        return response()->json(['message' => 'Student deleted successfully']);
    }
}
