<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function __construct()
    {

        //$this->middleware('api-auth', ['except' => []]);

    }
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'name' => 'required',
            'password' => 'required',
        ]);

        $http = new Client();
        if (empty(User::where('email', $request->email)->first())){
            $user = User::firstOrNew(['email' => $request->email]);
            $user->name = $request->name;
            $user->email = $request->email;
            //$user->city_id = $request->city_id;
            $user->password = bcrypt($request->password);
            $user->save();

            $response = $http->post(url('oauth/token'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => 2,
                    'client_secret' => 'yRdKO4UACutqNSVIqhqN9clkbBPeSwHjSU7KDnJW',
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => '',
                ],
            ]);

            return response(
                [
                    'data' => json_decode((string)$response->getBody(), true)
                ],
                    200);
        }
        else
            return response()->json(
                [
                    'error'=>'User with such e-mail already exists'
                ],
                    401);




    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'User not found. Check credentials'
                ],
                404);
        }
        if (Hash::check($request->password, $user->password)) {
            $http = new Client();

            try {
                $response = $http->post(url('oauth/token'), [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => 2,
                        'client_secret' => 'yRdKO4UACutqNSVIqhqN9clkbBPeSwHjSU7KDnJW',
                        'username' => $request->email,
                        'password' => $request->password,
                        'scope' => '',
                    ],
                ]);

                return response([
                    'data' => json_decode((string)$response->getBody(), true),
                ],
                    201);
            } catch (\Exception $e) {
                throw new \Exception($e);
            }


        }
        return response()->json(
            [
                'status' => 'error',
                'message' => 'E-mail or password is wrong. Check credentials'
            ],
            404);


    }

//    public function checkToken(Request $request)
//    {
//        $this->validate($request, [
//            'token' => 'required',
//        ]);
//        $status = true;
//        $decoded = JWTAuth::decode($request->token);
//        $expire = DB::table('oauth_access_tokens')->where('oauth_access_tokens.id', $decoded)
//            ->first(['expires_at']);
//        $current = date("Y-m-d h:i:s");
//        if($expire<$current)
//            $status = false;
//
//        return response()->json(
//            [
//                'status' => $decoded,
//
//            ],
//            200);
//
//
//    }




}
