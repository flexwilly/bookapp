<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            'create-permission',
            'edit-permission',
            'delete-permission',
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'delete-user',
            'create-book',
            'edit-book',
            'delete-book',
            'view-all-books',
            'create-loan-book',
            'edit-loan-book',
        ];

        //Loop through the permisssions and insert them into the permissions table
        foreach($permissions as $permision){
            Permission::create(['name'=>$permision]);
        }
    }
}
