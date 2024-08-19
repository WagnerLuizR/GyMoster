<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TrainingRequest;
use App\Models\Training;
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
 * Class TrainingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TrainingCrudController extends CrudController
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
        CRUD::setModel(Training::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/training');
        CRUD::setEntityNameStrings('Treino', 'Treinos');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->label('Nome');
        CRUD::column('description')->label('Descrição');

        CRUD::addColumn([
            'name' => 'difficult_level',
            'label' => 'Nível de dificuldade',
            'type' => 'select_from_array',
            'options' => ['i' => 'Iniciante', 'in' => 'Intermediário', 'a' => 'Avançado'],
            'allows_null' => false,
            'default' => 'i',
        ]);
        CRUD::column('duration')->label('Duração');

        CRUD::addColumn([
            'name' => 'type',
            'label' => 'Tipo',
            'type' => 'select_from_array',
            'options' => ['a' => 'Alongamento', 'c' => 'Cardio', 'm' => 'Musculação',
                'tf' => 'Treino Funcional', 'tfx' => 'Treino de Flexibilidade', 'tai' => 'Treino de Alta Intesidade',
                'tc' => 'Treino de Condicionamento', 'tm' => 'Treino de Mobilidade'],
            'allows_null' => false,
            'default' => 'a'
        ]);

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
        CRUD::setValidation(TrainingRequest::class);

        CRUD::field('name')->label('Nome');
        CRUD::field('description')->type('textarea')->label('Descrição');
        CRUD::addField([
            'name' => 'difficult_level',
            'label' => 'Nível de Dificuldade',
            'type' => 'select_from_array',
            'options' => ['i' => 'Iniciante', 'in' => 'Intermediário', 'a' => 'Avançado'],
            'allows_null' => false,
            'default' => 'i'
        ]);
        CRUD::field('duration')->type('time')->label('Duração');

        CRUD::addField([
            'name' => 'type',
            'label' => 'Tipo',
            'type' => 'select_from_array',
            'options' => ['a' => 'Alongamento', 'c' => 'Cardio', 'm' => 'Musculação',
                'tf' => 'Treino Funcional', 'tfx' => 'Treino de Flexibilidade', 'tai' => 'Treino de Alta Intesidade',
                'tc' => 'Treino de Condicionamento', 'tm' => 'Treino de Mobilidade'],
            'allows_null' => false,
            'default' => 'a'
        ]);

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
        // Retrieve all trainings from the database
        $trainings = Training::all();

        // Return a JSON response
        return response()->json([
            $trainings
        ]);
    }

    /**
     * Display a single training as JSON.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function showExposed(int $id): JsonResponse
    {
        $training = Training::find($id);

        if ($training) {
            return response()->json([
                $training
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Training not found'
            ], 404);
        }
    }

    /**
     * Create a new training and return the training data as JSON.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeExposed(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'difficultLevel' => 'required|in:i,in,a',
                'duration' => 'required|string',
                'type' => 'required|in:a,c,m,tf,tfx,tai,tc,tm',
            ]);

            $training = Training::create([
                'name' => $request->name,
                'description' => $request->description,
                'difficult_level' => $request->difficultLevel,
                'duration' => $request->duration,
                'type' => $request->type
            ]);

            return response()->json([
                $training
            ], 201);
        } catch (Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }

    /**
     * Update an existing training and return the updated data as JSON.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateExposed(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'difficultLevel' => 'required|in:i,in,a',
            'duration' => 'required|string',
            'type' => 'required|in:a,c,m,tf,tfx,tai,tc,tm',
        ]);

        $training = Training::find($id);

        if (!$training) {
            return response()->json([
                'success' => false,
                'message' => 'Training not found'
            ], 404);
        }

        $training->update([
            'name' => $request->name ?? $training->name,
            'description' => $request->description ?? $training->description,
            'difficult_level' => $request->difficultLevel ?? $training->difficult_level,
            'duration' => $request->duration ?? $training->duration,
            'type' => $request->type ?? $training->type,
        ]);

        return response()->json([
            $training
        ]);
    }

    /**
     * Delete an existing training and return a JSON response.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroyExposed(int $id): JsonResponse
    {
        $training = Training::find($id);

        if (!$training) {
            return response()->json([
                'success' => false,
                'message' => 'Training not found'
            ], 404);
        }

        $training->delete();

        return response()->json([
            'success' => true,
            'message' => 'Training deleted successfully'
        ]);
    }

}
