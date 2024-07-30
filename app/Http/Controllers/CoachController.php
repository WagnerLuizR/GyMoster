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
        $coachs = $this->service->findAllCoachs();
        return response()->json($coachs);
    }

    public function show($id)
    {
        $coach = $this->service->findCoachById($id);
        return response()->json($coach);
    }

    public function store(Request $request)
    {
        $coachId = $this->service->createCoach($request->all());
        $coach = $this->service->findCoachById($coachId);
        return response()->json($coach);
    }

    public function update(Request $request, $id)
    {
        $this->service->updateCoach($id, $request->all());
        $coach = $this->service->findCoachById($id);
        return response()->json($coach);
    }

    public function destroy($id)
    {
        $this->service->deleteCoach($id);
        return response()->json(['message' => 'Coach deleted successfully']);
    }
}
