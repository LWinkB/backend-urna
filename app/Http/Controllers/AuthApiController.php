<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTAuth;

class AuthApiController extends Controller
{
    protected $model;
    protected $pathCandidate;
    private $jwtAuth;

    public function __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        if (!$token = $this->jwtAuth->attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        $user = auth()->user();
        // all good so return the token
        return response()->json(compact('token', 'user'));
    }

    public function votation()
    {
        if (!$user = $this->jwtAuth->parseToken()->authenticate()) {
            return response()->json(['error' => 'user_not_found'], 404);
        }
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function refreshToken()
    {
        if (!$this->jwtAuth->getToken())
            return response()->json(['Error', 'Token_not_send'], 401);

        $token = $this->jwtAuth->refresh();
        return response()->json(compact('token'));
    }


    public function register(Request $request)
    {
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json('Cadastrado com sucesso!');
    }

    public function destroy($id)
    {
        $user = user::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado!'
            ], 404);
        }
        $user->delete();
        return response()->json([
            'message' => 'Deletado com sucesso!'
        ]);
    }

    public function logout()
    {
      $token = $this->jwtAuth->getToken();
      $this->jwtAuth->invalidate($token);

      return response()->json(['Logout']);

    }
}


