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
        $trainings = $this->service->findAllTrainings();
        return response()->json($trainings);
    }

    public function show($id)
    {
        $training = $this->service->findTrainingById($id);
        return response()->json($training);
    }

    public function store(Request $request)
    {
        $trainingId = $this->service->createTraining($request->all());
        $training = $this->service->findTrainingById($trainingId);
        return response()->json($training);
    }

    public function update(Request $request, $id)
    {
        $this->service->updateTraining($id, $request->all());
        $training = $this->service->findTrainingById($id);
        return response()->json($training);
    }

    public function destroy($id)
    {
        $this->service->deleteTraining($id);
        return response()->json(['message' => 'Training deleted successfully']);
    }
}
