<?php

namespace Laurel\Kanban\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Laurel\Kanban\App\Http\Resources\UserResource;
use Laurel\Kanban\App\Http\Requests\Auth\Login;
use Laurel\Kanban\App\Http\Requests\Auth\Register;
use Laurel\Kanban\App\Kanban;
use Laurel\Kanban\App\Models\Card;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function init(Request $request)
    {
        if ($request->user()) {
            return response([
                'data' => new UserResource($request->user())
            ]);
        } else {
            return response(['errors' => 'Unauthorized'], 401);
        }
    }

    public function login(Login $request)
    {
        try {
            $this->logout($request);

            if (!Auth::attempt([
                'email' => $request->validated()['email'],
                'password' => $request->validated()['password']
            ])) {
                return response([
                    'errors' => ['Invalid credentials...']
                ]);
            }

            $user = Auth::user();

            $tokenResult = $user->createToken(Str::random(60));
            $token = $tokenResult->token;

            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            $token->save();

            return response()->json([
               'access_token' => $tokenResult->accessToken,
               'token_type' => 'Bearer',
               'expires_at' => Carbon::parse(
                   $tokenResult->token->expires_at
               )->toDateTimeString(),
               'user' => new UserResource(Auth::user())
            ]);
        } catch (\Exception $e) {
            return response([
                'errors' => ['Couldnt login you. Try again later...']
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            if ($request->user() && $request->user()->token()) {
                $request->user()->token()->revoke();
            }

            return response([
                'status' => true
            ]);
        } catch (\Exception $e) {
            return response([
                'errors' => ['Could not logout you. Try again later...']
            ]);
        }
    }

    public function register(Register $request)
    {
        try {
            $this->logout($request);

            $userClass = config('laurel_kanban.user_class');
            $credentials = $request->validated();
            $credentials['password'] = bcrypt($credentials['password']);
            $user = new $userClass;
            $user->fill($credentials);
            $user->save();

            return response([
                'status' => true
            ]);
        } catch (\Exception $e) {
            return response([
                'errors' => ['Could not create user. Try again later...']
            ]);
        }
    }
}
