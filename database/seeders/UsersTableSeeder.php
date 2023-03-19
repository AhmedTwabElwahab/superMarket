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
            'name'      => 'admin',
            'username'  => 'superAdmin',
            'email'     => 'app@app.com',
            'password'  => bcrypt('123456'),
        ]);

        $user->attachRole('super_admin');
    }//end of run
}//end of seeder
