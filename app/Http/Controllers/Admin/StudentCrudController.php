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
use Illuminate\Http\RedirectResponse;

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

    public function store(): RedirectResponse
    {
        $this->crud->hasAccessOrFail('create');

        // Obter os dados da requisição
        $data = request()->all();

        // Verificar se os campos de peso e altura foram informados
        if (isset($data['weight']) && isset($data['height']) && $data['height'] > 0) {
            // Calcular o IMC
            $data['bmi'] = $data['weight'] / ($data['height'] * $data['height']);
        }

        // Salvar o registro com o IMC calculado
        $item = $this->crud->create($data);

        // Redirecionar após a criação
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
}
