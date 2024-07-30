<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Service\UserServiceInterface;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $pesquisar = $request->pesquisar ?? "";
        $perPage = $request->perPage ?? 5;
        $users = $this->service->index($pesquisar,$perPage);
        return response()->json($users);
    }

    public function show($id)
    {
        $registro = null;
        try {
            $registro = $this->service->show($id);
            return view('user.show',[
                'registro'=>$registro,
            ]);
        } catch(Exception $e) {
            return view('user.show',[
                'registro'=>$registro,
                'fail'=>'Registro não localizado '.$e->getMessage(),
            ]);
        }
    }

    public function store(UserFormRequest $request)
    {
        $registro = $request->all();

        try {
            $registro = $this->service->store($registro);
            $user = redirect()->route('user.index')->with('success','Registro cadastrado com sucesso!');
            return response()->json($user);
        } catch(Exception $e) {
            return view('user.create',[
                'registro'=>$registro,
                'fail'=>$e->getMessage(),
            ]);
        }
    }

    public function update(UserFormRequest $request, $id)
    {
        $registro = null;
        try {
          $this->service->update($id, $request->all());
        $user = $this->service->show($id);
        return response()->json($user);
        } catch(Exception $e) {
            return view('user.edit',[
                'registro'=>$registro,
                'fail'=>$e->getMessage(),
            ]);
        }
        
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return response()->json(['message' => 'User deleted successfully']);
    }
}
