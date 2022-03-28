<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'UserID' => '123456',
            'UserName' => 'Super Admin',
            'Designation' => 'Admin',
            'Password' => Hash::make('123456'),
            'Email' => 'zamil@gmail.com',
            'Active' => 'Y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Permission::create([
            'name' => 'Sample',
            'guard_name' => 'web',
            'active' => 'Y',
        ]);

        Permission::create([
            'name' => 'Permission Manager',
            'guard_name' => 'web',
            'active' => 'Y',
        ]);

        Permission::create([
            'name' => 'User Manager',
            'guard_name' => 'web',
            'active' => 'Y',
        ]);

        $user->givePermissionTo('Sample','Permission Manager','User Manager');

    }
}
