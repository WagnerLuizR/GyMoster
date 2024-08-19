<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ScheduleRequest;
use App\Models\Schedule;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ScheduleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ScheduleCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Schedule::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/schedule');
        CRUD::setEntityNameStrings('Agendamento', 'Agendamentos');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'student',
            'type' => 'select',
            'label' => 'Estudante',
            'entity' => 'student',
            'attribute' => 'nickname',
            'model' => 'App\Models\Student',
        ]);
        CRUD::addColumn([
            'name' => 'training',
            'type' => 'select',
            'label' => 'Treino',
            'entity' => 'training',
            'attribute' => 'name',
            'model' => 'App\Models\Training',
        ]);
        CRUD::column('date')->type('date')->label('Data');
        CRUD::column('start_time')->type('time')->label('Hora de início');
        CRUD::column('end_time')->type('time')->label('Hora de fim');
        CRUD::column('location')->type('text')->label('Localização');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ScheduleRequest::class);
        CRUD::addField([
            'name' => 'student_id',
            'label' => 'Estudante',
            'type' => 'select',

            'entity' => 'student',
            'model' => "App\Models\Student",
            'attribute' => 'nickname',
            'pivot' => true,

            'options' => (function ($query) {
                return $query->orderBy('nickname', 'ASC')->get();
            }),
        ]);
        CRUD::addField([
            'name' => 'training_id',
            'label' => 'Treino',
            'type' => 'select',

            'entity' => 'training',
            'model' => "App\Models\Training",
            'attribute' => 'name',
            'pivot' => true,

            'options' => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }),
        ]);
        CRUD::field('date')->type('date')->label('Data');
        CRUD::field('start_time')->type('time')->label('Hora de início');
        CRUD::field('end_time')->type('time')->label('Hora de fim');
        CRUD::field('location')->type('text')->label('Localização');
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    //exposed End-points:

    public function indexExposed(): JsonResponse
    {
        // Retrieve all schedules from the database
        $schedules = Schedule::all();

        // Return a JSON response
        return response()->json([
            $schedules
        ]);
    }

    /**
     * Display a single schedule as JSON.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function showExposed(int $id): JsonResponse
    {
        $schedule = Schedule::find($id);

        if ($schedule) {
            return response()->json([
                $schedule
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Schedule not found'
            ], 404);
        }
    }

    /**
     * Create a new schedule and return the schedule data as JSON.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeExposed(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'studentId' => 'required',
                'trainingId' => 'required',
                'date' => 'required',
                'startTime' => 'required',
                'endTime' => 'required',
                'location' => 'required',
            ]);

            $schedule = Schedule::create([
                'student_id' => $request->studentId,
                'training_id' => $request->trainingId,
                'date' => $request->date,
                'start_time' => $request->startTime,
                'end_time' => $request->endTime,
                'location' => $request->location
            ]);

            return response()->json([
                $schedule
            ], 201);
        } catch (Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }

    /**
     * Update an existing schedule and return the updated data as JSON.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateExposed(Request $request, int $id): JsonResponse
    {
        try {
            $request->validate([
                'studentId' => 'required',
                'trainingId' => 'required',
                'date' => 'required',
                'startTime' => 'required',
                'endTime' => 'required',
                'location' => 'required',
            ]);
            $schedule = Schedule::find($id);

            if (!$schedule) {
                return response()->json([
                    'success' => false,
                    'message' => 'Schedule not found'
                ], 404);
            }

            $schedule->update([
                'student_id' => $request->studentId ?? $schedule->student_id,
                'training_id' => $request->trainingId ?? $schedule->training_id,
                'date' => $request->date ?? $schedule->date,
                'start_time' => $request->startTime ?? $schedule->start_time,
                'end_time' => $request->endTime ?? $schedule->end_time,
                'location' => $request->location ?? $schedule->location,
            ]);

            return response()->json([
                $schedule
            ]);
        } catch (Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }

    /**
     * Delete an existing schedule and return a JSON response.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroyExposed(int $id): JsonResponse
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule not found'
            ], 404);
        }

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Schedule deleted successfully'
        ]);
    }
}
