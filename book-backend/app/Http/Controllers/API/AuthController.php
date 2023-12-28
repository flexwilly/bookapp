<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //function to register users
    public function register(Request $req){
       try{
        $validator = Validator::make($req->all(),[
          'name'=>'required',
          'email'=>'required|email',
          'password'=>'required',
          'c_password'=>'required|same:password'
        ]);

        if($validator->fails()){
            $response = [
                'status'=>false,
                'message'=>'Validation error',
                'errors'=>$validator->errors()
            ];
            return response()->json($response,401);
        }

        $input = $req->all();

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole('Student');
        $response = [
            'status'=>true,
            'message'=>"User Registered successfully",
            'token'=> $user->createToken("API Token")->plainTextToken
        ];

        return response()->json($response,200);
       }catch(\Throwable $th){
        $response= [
            'status'=>false,
            'message'=>$th->getMessage()
        ];
        return response()->json($response,500);
       }
    }

    //function to login user
    public function login(Request $req){

        try{
           $validateUser = Validator::make($req->all(),[
            'email'=>'required|email',
            'password'=>'required',
           ]);

           //if validation of user fails do this
           if($validateUser->fails()){
            $response = [
                'status'=>false,
                'message'=>'validation error',
                'error'=>$validateUser->errors()
            ];

            return response()->json($response,401);
           }

           //if login fails do this
           if(!Auth::attempt($req->only(['email','password']))){
              $response = [
                'status'=>false,
                'message'=>'Email and password do not match with our record',
              ];
                return response()->json($response,401);
           }
           //find user by email
           $user = User::where('email',$req->email)->first();

           $response = [
            'status'=>true,
            'message'=>'User Logged in successfully',
            'token'=> $user->createToken("API Token")->plainTextToken
           ];

           return response()->json($response,200);

        }
     catch(\Throwable $th){
        $response = [
            'status'=>false,
            'message'=> $th->getMessage()
        ];
        return response()->json($response,500);
     }
    }

    //logout function
    public function logout(Request $req){
        $req->user()->tokens()->delete();
        $response = [
         'message'=>'User Logged Out successfully'
        ];
        return response()->json($response,200);
    }

    //get logged in user
    public function user(Request $req){
        $user = $req->user();
        $role = $user->roles->pluck('name')->all();

        return response()->json([
            'user'=>$user,
            'role'=>$role
        ],200);
    }
}
