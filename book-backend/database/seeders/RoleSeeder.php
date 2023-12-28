<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::create(['name'=>'Super Admin']);
        $admin = Role::create(['name'=>'Admin']);
        $student  = Role::create(['name'=>'Student']);

        $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
            'create-book',
            'edit-book',
            'delete-book',
            'create-loan-book',
            'edit-loan-book',
        ]);

        $student->givePermissionTo([
            'create-loan-book',
            'edit-loan-book',
        ]);
    }
}
