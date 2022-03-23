<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthApiController extends Controller
{
    protected $model;
    protected $pathCandidate;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['authenticate', 'register']]);
    }

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = auth()->user();
        // all good so return the token
        return response()->json(compact('token', 'user'));
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function refreshToken()
    {
        if (!JWTAuth::getToken())
            return response()->json(['Error', 'Token_not_send'], 401);

        try {
            $token = JWTAuth::refresh();
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        }
        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {

        try {
            $user = new User;

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();


        } catch (\Exception $e) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
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
}


