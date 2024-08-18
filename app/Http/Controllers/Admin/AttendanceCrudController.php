<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
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
 * Class AttendanceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AttendanceCrudController extends CrudController
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
        CRUD::setModel(Attendance::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/attendance');
        CRUD::setEntityNameStrings('Presença', 'Presenças');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation(): void
    {
        CRUD::addColumn([
            'name' => 'student',
            'type' => 'select',
            'label' => 'Estudante',
            'entity' => 'student',
            'attribute' => 'nickname',
            'model' => 'App\Models\Student',
        ]);

        CRUD::column('attendance_date')->type('date')->label('Data');

        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select_from_array',
            'options' => ['p' => 'Presente', 'f' => 'Falta'],
            'allows_null' => false,
            'default' => 'p',
        ]);

        CRUD::addColumn([
            'name' => 'trainings', // Nome do relacionamento no modelo
            'type' => 'select_multiple',
            'label' => 'Treinos',
            'entity' => 'trainings', // Nome do método de relacionamento no modelo
            'attribute' => 'name', // Atributo do modelo Training que você quer exibir
            'model' => 'App\Models\Training', // Caminho completo para o modelo Training
        ]);
    }

    protected function setupShowOperation(): void
    {
        $this->setupListOperation();
    }


    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(AttendanceRequest::class);

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

        CRUD::addField([   // Date
            'name' => 'attendance_date',
            'label' => 'Data de Comparecimento',
            'type' => 'date'
        ]);

        CRUD::addField([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select_from_array',
            'options' => ['p' => 'Presente', 'f' => 'Falta'],
            'allows_null' => false,
            'default' => 'p',
        ]);

        CRUD::addField([
            'name' => 'trainings',
            'label' => 'Treinos',
            'type' => 'select_multiple',

            'entity' => 'trainings',
            'model' => "App\Models\Training",
            'attribute' => 'name',
            'pivot' => true,

            'options' => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }),
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    //exposed End-points:
    public function indexExposed(): JsonResponse
    {
        // Retrieve all attendances from the database
        $attendances = Attendance::all();

        // Return a JSON response
        return response()->json([
            $attendances
        ]);
    }

    /**
     * Display a single attendance as JSON.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function showExposed(int $id): JsonResponse
    {
        $attendance = Attendance::find($id);

        if ($attendance) {
            return response()->json([
                $attendance
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Attendance not found'
            ], 404);
        }
    }

    /**
     * Create a new attendance and return the attendance data as JSON.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeExposed(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'attendanceDate' => 'required',
                'status' => 'required|string',
                'studentId' => 'required',
            ]);

            $attendance = Attendance::create([
                'attendance_date' => $request->attendanceDate,
                'status' => $request->status,
                'student_id' => $request->studentId,
            ]);

            return response()->json([
                $attendance
            ], 201);
        } catch (Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }

    /**
     * Update an existing attendance and return the updated data as JSON.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateExposed(Request $request, int $id): JsonResponse
    {
        try {
            $request->validate([
                'attendanceDate' => 'required',
                'status' => 'required|string',
                'studentId' => 'required',
            ]);
            $attendance = Attendance::find($id);

            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attendance not found'
                ], 404);
            }

            $attendance->update([
                'attendance_date' => $request->attendanceDate ?? $attendance->attendance_date,
                'status' => $request->status ?? $attendance->status,
                'student_id' => $request->studentId ?? $attendance->student_id,
            ]);

            return response()->json([
                $attendance
            ]);
        } catch (Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }

    /**
     * Delete an existing attendance and return a JSON response.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroyExposed(int $id): JsonResponse
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance not found'
            ], 404);
        }

        $attendance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attendance deleted successfully'
        ]);
    }
}
