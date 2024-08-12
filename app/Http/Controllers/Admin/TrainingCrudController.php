<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TrainingRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TrainingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TrainingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Training::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/training');
        CRUD::setEntityNameStrings('training', 'trainings');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.


        CRUD::field('students');
        CRUD::addColumn([
            'name' => 'difficult_level',
            'label' => 'Difficult level',
            'type' => 'select_from_array',
            'options' => ['i' => 'Iniciante', 'in' => 'Intermediário', 'a' => 'Avançado'],
            'allows_null' => false,
            'default' => 'i'
        ]);
        CRUD::addColumn([
            'name' => 'type',
            'label' => 'Type',
            'type' => 'select_from_array',
            'options' => ['a' => 'Alongamento', 'c' => 'Cardio', 'm' => 'Musculação',
                'tf' => 'Treino Funcional', 'tfx' => 'Treino de Flexibilidade', 'tai' => 'Treino de Alta Intesidade',
                'tc' => 'Treino de Condicionamento', 'tm' => 'Treino de Mobilidade'],
            'allows_null' => false,
            'default' => 'a'
        ]);
        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
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
        CRUD::setFromDb(); // set fields from db columns.

        CRUD::addField([
            'name' => 'difficult_level',
            'label' => 'Difficult level',
            'type' => 'select_from_array',
            'options' => ['i' => 'Iniciante', 'in' => 'Intermediário', 'a' => 'Avançado'],
            'allows_null' => false,
            'default' => 'i'
        ]);
        CRUD::addField([
            'name' => 'type',
            'label' => 'Type',
            'type' => 'select_from_array',
            'options' => ['a' => 'Alongamento', 'c' => 'Cardio', 'm' => 'Musculação',
                'tf' => 'Treino Funcional', 'tfx' => 'Treino de Flexibilidade', 'tai' => 'Treino de Alta Intesidade',
                'tc' => 'Treino de Condicionamento', 'tm' => 'Treino de Mobilidade'],
            'allows_null' => false,
            'default' => 'a'
        ]);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
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
