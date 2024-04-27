<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 
                  'user'];

        foreach($roles as $role){
            $exists = Role::where('name', $role)->first();
            if(!$exists){
                $newRole = Role::create(['name' => $role]);
            }
        }
    }
}
