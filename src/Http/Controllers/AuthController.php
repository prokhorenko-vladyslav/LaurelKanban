<?php

namespace Laurel\Kanban\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laurel\Kanban\Http\Resources\UserResource;
use Laurel\Kanban\Http\Requests\AuthLogin;
use Laurel\Kanban\Http\Requests\AuthRegister;
use Laurel\Kanban\Kanban;
use Laurel\Kanban\Models\Card;

class AuthController extends Controller
{
    public function init(Request $request)
    {
    }

    public function login(AuthLogin $request)
    {
        try {
            $this->logout($request);
            
            if (Auth::attempt([
                'email' => $request->validated()['email'],
                'password' => $request->validated()['password']
                ])) {
                return response([
                    'data' => new UserResource(Auth::user())
                ]);
            } else {
                return response([
                    'errors' => ['Invalid credentials...']
                ]);
            }
        } catch (\Exception $e) {
            return response([
                'errors' => ['Couldnt login you. Try again later...']
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            return response([
                'data' => true
            ]);
        } catch (\Exception $e) {
            return response([
                'errors' => ['Could not logout you. Try again later...']
            ]);
        }
    }

    public function register(AuthRegister $request)
    {
        try {
            $userClass = config('laurel_kanban.user_class');
            $credentials = $request->validated();
            $credentials['password'] = bcrypt($credentials['password']);
            $user = new $userClass;
            $user->fill($credentials);
            $user->save();
            Auth::login($user);

            return response([
                'data' => new UserResource($user)
            ]);
        } catch (\Exception $e) {
            return response([
                'errors' => ['Couldnt create user. Try again later...']
            ]);
        }
    }
}
