<?php

namespace Laurel\Kanban\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laurel\Kanban\Http\Resources\UserResource;
use Laurel\Kanban\Http\Requests\AuthRegister;
use Laurel\Kanban\Kanban;
use Laurel\Kanban\Models\Card;

class AuthController extends Controller
{
    public function init(Request $request)
    {
    }

    public function login(Request $request)
    {
    }

    public function register(AuthRegister $request)
    {
        $userClass = config('laurel_kanban.user_class');
        $credentials = $request->validated();
        $credentials['password'] = bcrypt($credentials['password']);
        $user = new $userClass;
        $user->fill($credentials);
        $user->save();
        Auth::login($user);

        return true;
    }
}
