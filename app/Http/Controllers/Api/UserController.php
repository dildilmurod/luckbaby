<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function __construct()
    {

        $this->middleware('api-auth', ['except' => []]);
        $this->middleware('publisher', ['except' => ['user_data', 'user_show']]);
        $this->middleware('content-manager', ['except' => ['user_data', 'user_show']]);
        $this->middleware('editor', ['except' => ['user_data', 'user_show', 'user_search']]);
        $this->middleware('admin', ['except' => ['user_data', 'user_show', 'user_search', 'users']]);


    }

    public function user_data(Request $request){
        $uid = auth('api')->user()->id;
        $formInput = $request->except([]);
        $this->validate($request, [
//            'phone' => 'required',
            'avatar' => 'image|mimes:png,jpg,jpeg,gif|max:10000',

        ]);
        $user = User::find($uid);
        $name = $user->name;
        $user->phone = $request->phone;
        $user->adress = $request->adress;
        $user->gender = $request->gender;
        $user->city_id = $request->city_id;;
        $user->birthday = $request->birthday;
        $user->device_token = $request->device_token;

        $avatar = $request->file('avatar');
        //required if files from input exists{

        if (!empty($avatar)) {
            /*Storage::delete('public/user_images/featured' . $user->avatar);*/
            $avatarName = $avatar->getClientOriginalName();
            //just filename
            $filename = pathinfo($avatarName, PATHINFO_FILENAME);
            //just file extension
            $ext = $avatar->getClientOriginalExtension();
            //filename to store
            $fileToStore = md5(uniqid($filename)) . '_' . time() . '.' . $ext;
            $avatar->move('avatars', $fileToStore);
            $formInput['avatar'] = $fileToStore;
            $user->avatar = $formInput['avatar'];
        }
        if($user->save()){
            return response()->json(
                [
                    'msg' => 'User '.$name.' data stored successfully',

                ],
                201);
        }
        return response()->json(
            [
                'msg' => 'Something went wrong',

            ],
            400);


    }

    public function assign_role(Request $request){
        $this->middleware('admin');
        $role_id = $request->role_id;
        if(($role_id <= 4) && ($role_id >= 0)){
            $user = User::find($request->user_id);
            $user->role_id = $role_id;
            if($user->role_id == 0 || auth('api')->user()->role_id == 0){
                return response()->json(
                    [
                        'msg' => 'Cannot make admin role_id as ' . $role_id . '',

                    ],
                    200);
            }
            $user->publisher_id = $request->publisher_id;
            $user->save();
            return response()->json(
                [
                    'msg' => 'User with id ' . $request->user_id . ' made role_id as ' . $role_id . '',

                ],
                200);
        }
        return response()->json(
            [
                'msg' => 'There is no such kind of role_id at all',

            ],
            404);

    }

    public function user_search(Request $request){
        $user = User::query();
        if ($request->has('name')) {
            $user = User::where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->has('sname')) {
            $user = $user->where('sname', 'like', '%'.$request->sname.'%');
        }

        $user = $user->orderBy('id', 'desc')->get();
//        $user->makeHidden(['author_id', 'publisher_id', 'created_at', 'updated_at']);

        return response()->json(
            [
                'user' => $user,

            ],
            200);

    }

    public function user_show($id){
        $user = User::find($id);
        if($user) {
            return response()->json(
                [
                    'user' => $user,

                ],
                200);
        }
        return response()->json(
            [
                'msg' => 'User is not found',

            ],
            404);
    }






}
