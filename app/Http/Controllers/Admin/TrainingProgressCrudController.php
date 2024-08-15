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
}
