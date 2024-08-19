<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends CrudController
{

    public function setup(): void
    {
        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/login');
        CRUD::setEntityNameStrings('Usuário', 'Usuários');
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Buscar o usuário pelo nome
        $user = User::where('email', $request->input('email'))->first();

        // Verificar se o usuário foi encontrado e se a senha está correta
        if ($user && Hash::check($request->input('password'), $user->password)) {

            // Retornar o token CSRF
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
            ], 200);
        }

        // Retornar erro se o nome ou senha estiverem incorretos
        return response()->json([
            'message' => 'Invalid name or password',
        ], 401);


    }
}
