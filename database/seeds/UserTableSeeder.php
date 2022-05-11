<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $role_admin = Role::where('name', 'admin')->first();        
        $user = new User();
        $user->name = 'Administrador';
        $user->email = 'admin@admin.com.mx';
        $user->password = bcrypt('Apl1caci0n3$.2022');
        $user->save();
        $user->roles()->attach($role_admin);
    }
}
