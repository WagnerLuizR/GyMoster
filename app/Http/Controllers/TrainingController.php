<?php

namespace App\Http\Controllers;

use App\Services\TrainingService;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    protected $service;

    public function __construct(TrainingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $students = $this->service->findAllTrainings();
        return response()->json($students);
    }

    public function show($id)
    {
        $student = $this->service->findTrainingById($id);
        return response()->json($student);
    }

    public function store(Request $request)
    {
        $studentId = $this->service->createTraining($request->all());
        $student = $this->service->findTrainingById($studentId);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $this->service->updateTraining($id, $request->all());
        $student = $this->service->findTrainingById($id);
        return response()->json($student);
    }

    public function destroy($id)
    {
        $this->service->deleteTraining($id);
        return response()->json(['message' => 'Training deleted successfully']);
    }
}
