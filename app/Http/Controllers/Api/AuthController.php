<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Auth;
use Illuminate\Support\Collection;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validasi gagal', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = $this->authAttempt(Auth::user());

            return $this->sendResponse($user, 'Login User Berhasil');
        }
        else{
            return $this->sendError('Token tidak terdaftar', ['error' => 'Token tidak terdaftar']);
        }
    }

    public function unauthorized()
    {
        return $this->sendError('Token tidak terdaftar', ['error' => 'Token tidak terdaftar'], 401);
    }

    public function authAttempt($user)
    {
        $ability = [];
        array_push($ability, collect([
            "action"    => "view",
            "subject"   => "HOME"
        ]));
        array_push($ability, collect([
            "action"    => "view",
            "subject"   => "MISC"
        ]));

        foreach ($user->getPermissionsViaRoles() as $key => $value) {
            array_push($ability, collect([
                "action"    => "view",
                "subject"   => $value->name
            ]));
        }

        // echo $user->createToken(env('SANCTUM_TOKEN', 'pppi'))->plainTextToken;
        // $data->token = $user->createToken(env('SANCTUM_TOKEN', 'pppi'))->plainTextToken;
        // $data->userData = collect([
        //     "role" => $user->roles[0]->name,
        //     "ability" => $ability,
        //     ...$user
        // ]);
        // unset($user->roles);

        // return $data;
        return collect([
            "token" => $user->createToken(env('SANCTUM_TOKEN', 'pppi'))->plainTextToken,
            "userData" => [
                "role" => $user->roles[0]->name,
                "ability" => $ability,
                "id" => $user->id,
                "email" => $user->email,
                "name" => $user->name
            ]
        ]);
    }
}
