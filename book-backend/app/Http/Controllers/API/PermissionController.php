<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum');
        $this->middleware('permission:create-permission|edit-permission|delete-permission',['only'=>['index','show']]);
        $this->middleware('permission:create-permission',['only'=>['store']]);
        $this->middleware('permission:edit-permission',['only'=>['update']]);
        $this->middleware('permission:delete-permission',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $permissions = Permission::all();
        $role_permissions = Permission::get();
        return response()->json([
            'status'=>true,
            'permissions'=>$permissions,
            'role_permissions'=>$role_permissions
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
        $validator = Validator::make($request->only('name'),[
            'name'=>'required|string|max:250|unique:permissions,name'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Validaton error',
                'errors'=>$validator->errors(),
            ],401);
        }

       $input = $request->only('name');
       Permission::create($input);
       return response()->json([
        'status'=>true,
        'message'=>'Permission created successfully'
       ],200);
    }catch(\Throwable $th){
        return response()->json([
            'status'=>false,
            'message'=>$th->getMessage(),
        ],500);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
        return response()->json([
            'status'=>true,
            'permission'=>$permission
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
        try{
            $validator = Validator::make($request->only('name'),[
                'name'=>'required|string|max:250|unique:permissions,name'
            ]);

            if($validator->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>'Validaton error',
                    'errors'=>$validator->errors(),
                ],401);
            }

           $input = $request->only('name');
           $permission->update($input);
           return response()->json([
            'status'=>true,
            'message'=>'Permission updated successfully',
           ],200);


        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage(),
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json([
            'status'=>true,
            'message'=>'Permission deleted successfully',
        ],200);
    }
}
