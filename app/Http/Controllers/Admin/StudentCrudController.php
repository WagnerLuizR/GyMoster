<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class StudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class StudentCrudController extends CrudController
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
    public function setup(): void
    {
        CRUD::setModel(Student::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/student');
        CRUD::setEntityNameStrings('Estudante', 'Estudantes');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation(): void
    {
        CRUD::column('nickname')->type('text')->label('Nome');

        CRUD::addColumn([
            'name' => 'gender',
            'label' => 'Gênero',
            'type' => 'select_from_array',
            'options' => ['M' => 'Homem', 'F' => 'Mulher', 'O' => 'Outro'],
            'allows_null' => false,
            'default' => 'O'
        ]);

        CRUD::column('height')->type('number')->label('Altura');
        CRUD::column('weight')->type('number')->label('Peso');

        CRUD::column('bmi')->type('number')->label('IMC');


        CRUD::addColumn([
            'name' => 'trainings', // Nome do relacionamento no modelo
            'type' => 'select_multiple',
            'label' => 'Treinos',
            'entity' => 'trainings', // Nome do método de relacionamento no modelo
            'attribute' => 'name', // Atributo do modelo Training que você quer exibir
            'model' => 'App\Models\Training', // Caminho completo para o modelo Training
        ]);

        CRUD::column('created_at')->type('datetime')->label('Criado em');
        CRUD::column('updated_at')->type('datetime')->label('Atualizado em');
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
        CRUD::setValidation(StudentRequest::class);
        CRUD::field('nickname')->type('text')->label('Nome');
        CRUD::field('age')->type('number')->label('Idade');
        CRUD::addField([
            'name' => 'gender',
            'label' => 'Gênero',
            'type' => 'select_from_array',
            'options' => ['M' => 'Homem', 'F' => 'Mulher', 'O' => 'Outro'],
            'allows_null' => false,
            'default' => 'O'
        ]);
        CRUD::field('height')->type('number')->label('Altura')->attributes(['step' => '0.01']);
        CRUD::field('weight')->type('number')->label('Peso')->attributes(['step' => '0.01']);

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

    public function store(Request $request): RedirectResponse
    {
        $this->crud->hasAccessOrFail('create');

        // Obter os dados da requisição

        $data = $this->calculateImc($request);

        // Salvar o registro com o IMC calculado
        $item = $this->crud->create($data);

        // Redirecionar após a criação
        return $this->crud->performSaveAction($item->getKey());
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->crud->hasAccessOrFail('update');

        $data = $this->calculateImc($request);

        $item = $this->crud->update($id, $data);

        return $this->crud->performSaveAction($item->getKey());
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

    /**
     * @param Request $request
     * @return array
     */
    public function calculateImc(Request $request): array
    {
        $data = $request->all();

        // Verificar se os campos de peso e altura foram informados
        if (isset($data['weight']) && isset($data['height']) && $data['height'] > 0) {
            // Calcular o IMC
            $data['bmi'] = $data['weight'] / ($data['height'] * $data['height']);
        }

        return $data;
    }

    public function indexExposed(): JsonResponse
    {
        // Retrieve all students from the database
        $students = Student::all();

        // Return a JSON response
        return response()->json([
            $students
        ]);
    }

    /**
     * Display a single student as JSON.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function showExposed(int $id): JsonResponse
    {
        $student = Student::find($id);

        if ($student) {
            return response()->json([
                $student
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }
    }

    /**
     * Create a new student and return the student data as JSON.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeExposed(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nickname' => 'required|string|max:255',
                'age' => 'required|integer',
                'gender' => 'required',
                'height' => 'required|numeric',
                'weight' => 'required|numeric',
            ]);

            $data = $this->calculateImc($request);

            $student = $this->crud->create($data);

            return response()->json([
                $student
            ], 201);
        } catch (Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }

    /**
     * Update an existing student and return the updated data as JSON.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateExposed(Request $request, int $id): JsonResponse
    {
        try {
            $student = Student::find($id);

            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }
            $request->validate([
                'nickname' => 'required|min:4|max:255',
                'age' => 'required|integer',
                'gender' => 'required',
                'height' => 'required|numeric',
                'weight' => 'required|numeric'
            ]);

            if ($request->weight != $student->weight || $request->height != $student->height) {
                $data = $this->calculateImc($request);

                $response = $this->crud->update($id, $data);
                // Redirecionar após a criação
                return response()->json([
                    $response
                ]);
            } else {

                $student->update([
                    'nickname' => $request->nickname ?? $student->nickname,
                    'age' => $request->age ?? $student->age,
                    'gender' => $request->gender ?? $student->gender,
                    'height' => $request->height ?? $student->height,
                    'weight' => $request->weight ?? $student->weight,
                    'bmi' => $request->bmi ?? $student->bmi,
                    "created_at" => $request->created_at ?? $student->created_at,
                    'updated_at' => $request->updated_at ?? $student->updated_at,
                ]);

                return response()->json([
                    $student
                ]);
            }
        } catch (Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }

    /**
     * Delete an existing student and return a JSON response.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroyExposed(int $id): JsonResponse
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully'
        ]);
    }
}
