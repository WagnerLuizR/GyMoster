<?php

namespace App\Http\Controllers;

use App\Services\CoachService;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    protected $service;

    public function __construct(CoachService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $students = $this->service->findAllCoachs();
        return response()->json($students);
    }

    public function show($id)
    {
        $student = $this->service->findCoachById($id);
        return response()->json($student);
    }

    public function store(Request $request)
    {
        $studentId = $this->service->createCoach($request->all());
        $student = $this->service->findCoachById($studentId);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $this->service->updateCoach($id, $request->all());
        $student = $this->service->findCoachById($id);
        return response()->json($student);
    }

    public function destroy($id)
    {
        $this->service->deleteCoach($id);
        return response()->json(['message' => 'Coach deleted successfully']);
    }
}
