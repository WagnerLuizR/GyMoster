<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NutritionalPlanRequest;
use App\Models\NutritionalPlan;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NutritionalPlanCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class NutritionalPlanCrudController extends CrudController
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
        CRUD::setModel(NutritionalPlan::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/nutritional-plan');
        CRUD::setEntityNameStrings('Plano Nutricional', 'Planos Nutricionais');
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
        CRUD::column('plan_description')->type('textarea')->label('Plano Nutricional');
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
        CRUD::setValidation(NutritionalPlanRequest::class);
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
        CRUD::field('plan_description')->type('textarea')->label('Plano Nutricional');
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
