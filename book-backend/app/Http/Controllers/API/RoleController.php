<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    //constructor
    public function __construt(){
        $this->middleware('auth:sanctum');
        $this->middleware('permission:create-role|edit-role|delete-role',['only'=>['index','show']]);
        $this->middleware('permission:create-role',['only'=>['store']]);
        $this->middleware('permission:edit-role',['only'=>['update','edit']]);
        $this->middleware('permission:delete-role',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $permissions = Permission::all();
        $roles =  Role::orderBy('id','ASC')->get();
        $user_roles = Role::pluck('name')->all();
        $response  = [
            'status'=>true,
            'roles'=>$roles,
            'user_roles'=>$user_roles,
            'permissions'=>$permissions,
        ];
        return response()->json($response,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        //
     try{
        $validator = Validator::make($req->only(['name','permissions']),
            [
                'name'=>'required|string|max:250|unique:roles,name',
                'permissions'=>'required'
            ]
        );

        if($validator->fails()){
            $response = [
                'status'=>false,
                'message'=>'Validation error',
                'errors'=>$validator->errors()

            ];

            return response()->json($response,401);
        }

        $input = $req->only(['name','permissions']);
        $role = Role::create($input);


        //$permissions = Permission::whereIn('id', $req->permissions)->get(['name'])->toArray();

        $role->syncPermissions($req->permissions);


        $response = [
            'status'=>true,
            'message'=>"Role created successfully",
            'role'=>$role,

        ];
        return response()->json($response,200);
    }
    catch(\Throwable $th){
        $response= [
            'status'=>false,
            'message'=>$th->getMessage()
        ];
        return response()->json($response,500);

    }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //show all permissions assigned to a specific role
        $rolePermissions = Permission::join("role_has_permissions","permission_id","=","id")
            ->where("role_id",$role->id)
            ->select('name')
            ->get();
        $response =  [
            'status'=>true,
            'role'=>$role,
            'rolePermissions'=>$rolePermissions
        ];
        return response()->json($response,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, Role $role)
    {
        //
        try{

            $validator = Validator::make($req->all(),[
                'name'=>'required|string|max:250',
                'permissions'=>'required'

            ]);

            if($validator->fails()){
                $response = [
                    'status'=>false,
                    'message'=>'Validation error',
                    'errors'=>$validator->errors()

                ];

                return response()->json($response,401);
            }

            $input = $req->only(['name','permissions']);
            $role->update($input);


            //$permissions = Permission::whereIn('id', $req->permissions)->get(['name'])->toArray();
            $role->syncPermissions($req->permissions);

            return response()->json([
                'status'=>true,
                'message'=>'Role updated successfully',
            ],200);


        }catch(\Throwable $th){
            $response= [
                'status'=>false,
                'message'=>$th->getMessage()
            ];
            return response()->json($response,500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try{

        if($role->name=='Super Admin'){
            return response()->json([
                'status'=>false,
                'message'=>'SUPER ADMIN ROLE CAN NOT BE DELETED',
            ],403);

        }
        // if(auth()->user()->hasRole($role->name)){
        //     return response()->json([
        //         'status'=>false,
        //         'message'=>'CANNOT DELETE SELF ASSIGNED ROLE',
        //     ],403);
        // }


        $role->delete();

        return response()->json(
            [
                'status'=>true,
                'message'=>'Role deleted successfully',

            ],200
        );
    }catch(\Throwable $th){
        $response= [
            'status'=>false,
            'message'=>$th->getMessage()
        ];
        return response()->json($response,500);
    }
    }

    }
