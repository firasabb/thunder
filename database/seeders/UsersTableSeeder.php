<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Example',
            'last_name' => 'Example',
            'username' => 'example',
            'email' => 'example@example.com',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => bcrypt('123123qweqwe')
        ]);

        $user->assignRole(['admin', 'user']);
    }
}
