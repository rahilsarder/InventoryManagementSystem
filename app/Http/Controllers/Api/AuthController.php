<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    private static $passport;

    public function __construct()
    {
        self::$passport = Passport::$clientModel::where('name', 'Laravel Password Grant Client')->first();
    }

    public function signup(Request $req)
    {
        $req->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'name' => 'required',
        ]);

        $user = User::create([
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'name' => $req->name,
        ]);

        $http = $this->createAuthToken($req);

        return response()->json([
            'user' => $user,
            'token' => $http,
        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $user = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if (!$user) {
            return response()->json([
                'message' => '
                Invalid credentials'
            ], 401);
        }

        $http = $this->createAuthToken($request);

        return response()->json($http);
    }

    public function refreshToken(Request $request)
    {

        $request->validate([
            'refresh_token' => 'required'
        ]);

        $http = $this->oauthRefreshToken($request);

        return response()->json($http);
    }

    static function createAuthToken(Request $request)
    {

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => self::$passport->id,
            'client_secret' => self::$passport->secret,
            'scope' => '*',
            'username' => request("email"),
        ]);

        $proxy = Request::create('/oauth/token', 'POST', $request->all());

        $response = Route::dispatch($proxy);

        $token = json_decode($response->getContent());

        return $token;
    }

    static function oauthRefreshToken(Request $request)
    {
        $request->request->add([
            'grant_type' => 'refresh_token',
            'client_id' => self::$passport->id,
            'client_secret' => self::$passport->secret,
            'scope' => '*',
            'refresh_token' => request("refresh_token"),
        ]);

        $proxy = Request::create('/oauth/token', 'POST', $request->all());

        $response = Route::dispatch($proxy);

        $token = json_decode($response->getContent());

        return $token;
    }

    public function getRelation()
    {
        $uid = Auth()->user()->id;

        $user = User::find($uid)->with('subscription')->get();

        return response()->json([
            'user' => $user
        ]);
    }

    public function getUserInfo()
    {
        return response()->json(Auth::user());
    }
}
