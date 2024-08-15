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
}
