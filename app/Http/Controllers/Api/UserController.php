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
        $this->middleware('auth', ['except'=>[]]);
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

    public function display(){
        return view('user.profile');
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
