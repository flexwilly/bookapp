<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware("auth:sanctum");
        $this->middleware('permission:create-user|edit-user|delete-user',['only'=>['index','show']]);
        $this->middleware('permission:create-user',['only'=>['store']]);
        $this->middleware('permission:edit-user',['only'=>['update','edit']]);
        $this->middleware('permission:delete-user',['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all users
        $users = User::latest('id')->get();

        return response()->json([
            'status'=>true,
            'users'=>$users,
        ],200);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
     try{
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Validation error',
                'errors'=>$validator->errors(),
            ],401);
        }

        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $user= User::create($input);
        $user->assignRole($request->role);

        return response()->json([
          'status'=>true,
          'message'=>'User created successfully'
        ],200);
    }catch(\Throwable $th){
        return response()->json(
            [
                'status'=>false,
                'message'=>$th->getMessage(),
            ],500);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        $role = $user->roles->pluck('name')->all();
        $response = [
            'status'=>true,
            'user'=>$user,
            'roles'=>$role
        ];
        return response()->json($response,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
      try{
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Validation error',
                'errors'=>$validator->errors(),
            ],401);
        }




        $input = $request->all();
        if(!empty($request->password)){
            $input['password'] = Hash::make($request->password);
        }else{
            $input = $request->except('password');
        }
        $user->update($input);

        $user->syncRoles($request->role);

        return response()->json([
          'status'=>true,
          'message'=>'User Updated Successfully'
        ],200);
    }catch(\Throwable $th){
        return response()->json(
            [
                'status'=>false,
                'message'=>$th->getMessage(),
            ],500);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user,Request $req)
    {

       if($user->hasRole('Super Admin') || $user->id == $req->user()->id){
        return response()->json([
            'status'=>false,
            'message'=>'USER DOES NOT HAVE THE RIGHT PERMISSIONS'
        ],403);
       }

        $user->syncRoles([]);
        //find user by id then delete him/her

        $user->delete();
        $response = [
          'success'=>true,
          'message'=>'User Deleted Successfully'
        ];

        return response()->json($response,200);
    }



}
