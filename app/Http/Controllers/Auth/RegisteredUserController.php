<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repository\UsersRepository;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    protected $repository;

    public function __construct(UsersRepositoy $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
                'password' => ['required', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->input('password')),
            ]);

            event(new Registered($user));
            
            $studentId = $this->service->createCoach($request->all());
            $student = $this->service->findCoachById($studentId);
            

            Auth::login($user);

            return response()->json($student);
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Registration Error: '.$e->getMessage());
            return response()->json(['error' => 'An error occurred while registering the user.'], 500);
        }
    }
}
