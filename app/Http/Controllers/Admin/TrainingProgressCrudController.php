<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TrainingProgressRequest;
use App\Models\TrainingProgress;
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
 * Class TrainingProgressCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TrainingProgressCrudController extends CrudController
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
        CRUD::setModel(TrainingProgress::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/training-progress');
        CRUD::setEntityNameStrings('Progresso de treino', 'Progressos de treino');
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
        CRUD::column('stars')->label('Pontuação')->type('text');
        CRUD::column('progress_description')->type('textarea')->label('Progresso de treino');
        CRUD::column('date')->type('date')->label('Data');
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
        CRUD::setValidation(TrainingProgressRequest::class);
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
        CRUD::addField([
            'name' => 'progress_point',
            'label' => 'Pontuação',
            'type' => 'select_from_array',
            'options' => [1 => '1', 2 => '2', 3 => '3',
                4 => '4', 5 => '5', 6 => '6', 7 => '7'],
            'allows_null' => false,
            'default' => 1
        ]);

        CRUD::field('progress_description')->type('textarea')->label('Progresso de treino');
        CRUD::field('date')->type('date')->label('Data');
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
        // Retrieve all trainingProgress from the database
        $trainingProgresss = TrainingProgress::all();

        // Return a JSON response
        return response()->json([
            $trainingProgresss
        ]);
    }

    /**
     * Display a single TrainingProgress as JSON.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function showExposed(int $id): JsonResponse
    {
        $trainingProgress = TrainingProgress::find($id);

        if ($trainingProgress) {
            return response()->json([
                $trainingProgress
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'TrainingProgress not found'
            ], 404);
        }
    }

    /**
     * Create a new TrainingProgress and return the TrainingProgress data as JSON.
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
                'progressDescription' => 'required',
                'progressPoint' => 'required',
                'date' => 'required',
            ]);

            $trainingProgress = TrainingProgress::create([
                'student_id' => $request->studentId,
                'training_id' => $request->trainingId,
                'progress_description' => $request->progressDescription,
                'progress_point' => $request->progressPoint,
                'date' => $request->date
            ]);

            return response()->json([
                $trainingProgress
            ], 201);
        } catch (Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }

    /**
     * Update an existing TrainingProgress and return the updated data as JSON.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateExposed(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'studentId' => 'required',
            'trainingId' => 'required',
            'progressDescription' => 'required',
            'progressPoint' => 'required',
            'date' => 'required|date',
        ]);
        $trainingProgress = TrainingProgress::find($id);

        if (!$trainingProgress) {
            return response()->json([
                'success' => false,
                'message' => 'TrainingProgress not found'
            ], 404);
        }

        $trainingProgress->update([
            'student_id' => $request->studentId ?? $trainingProgress->student_id,
            'training_id' => $request->trainingId ?? $trainingProgress->training_id,
            'progress_description' => $request->progressDescription ?? $trainingProgress->progress_description,
            'date' => $request->date ?? $trainingProgress->date
        ]);

        return response()->json([
            $trainingProgress
        ]);
    }

    /**
     * Delete an existing TrainingProgress and return a JSON response.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroyExposed(int $id): JsonResponse
    {
        $trainingProgress = TrainingProgress::find($id);

        if (!$trainingProgress) {
            return response()->json([
                'success' => false,
                'message' => 'TrainingProgress not found'
            ], 404);
        }

        $trainingProgress->delete();

        return response()->json([
            'success' => true,
            'message' => 'TrainingProgress deleted successfully'
        ]);
    }
}
