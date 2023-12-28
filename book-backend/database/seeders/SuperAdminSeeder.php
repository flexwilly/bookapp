<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create super admin
        $superAdmin = User::create([
            'name'=>'James Situma',
            'email'=>'situma@gmail.com',
            'password'=>Hash::make('password'),
        ]);

        $superAdmin->assignRole('Super Admin');

        //create admin
        $admin = User::create([
            'name'=>'Wilson Onjore',
            'email'=>'onjorew@gmail.com',
            'password'=>Hash::make('password')
        ]);
        $admin->assignRole('Admin');

        $student  = User::create([
            'name'=>'Carmen Rolla',
            'email'=>'rolla@gmail.com',
            'password'=>Hash::make('password')
        ]);

        $student->assignRole('Student');
    }
}
