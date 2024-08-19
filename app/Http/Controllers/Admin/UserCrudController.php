<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
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
use Illuminate\Support\Facades\Hash;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('Usuário', 'Usuários');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation(): void
    {
        CRUD::column('name')->label('Nome');
        CRUD::column('email')->label('Email');
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
        CRUD::setValidation(UserRequest::class);
        CRUD::field('name')->label('Nome');
        CRUD::field('email')->type('email')->label('Email');
        CRUD::field('password')->label('Senha');
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
    public function indexExposed(Request $request): JsonResponse
    {
        // Retrieve all users from the database
        $users = User::all();

        // Return a JSON response
        return response()->json([
            $users
        ]);
    }

    /**
     * Display a single user as JSON.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function showExposed(int $id): JsonResponse
    {
        $user = User::find($id);

        if ($user) {
            return response()->json([
                $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
    }

    /**
     * Create a new user and return the user data as JSON.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeExposed(Request $request): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                $user
            ], 201);
        } catch (Exception $exception) {
            return response()->json([$exception->getMessage(), 'ERRO AO SALVAR']);
        }
    }

    /**
     * Update an existing user and return the updated data as JSON.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateExposed(Request $request, int $id): JsonResponse
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
        try {
            $user->update([
                'name' => $request->name ?? $user->name,
                'email' => $request->email ?? $user->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);

            return response()->json([
                $user
            ]);
        } catch (Exception $exception) {
            return response()->json([$exception]);
        }
    }

    /**
     * Delete an existing user and return a JSON response.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroyExposed(int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
