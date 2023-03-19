<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            [
                'id'                => 100,
                'name'              => 'علي احمد محمد',
                'sub_account_id'    => CLIENTS_ACCOUNT,
            ],
            [
                'id'                => 101,
                'name'              => 'محمود سامي',
                'sub_account_id'    => CLIENTS_ACCOUNT,
            ]
        ]);
        DB::table('clients')->insert([
            [
                'name'          => 'علي احمد محمد',
                'email'         => 'ahmedrayes@gmail.com',
                'number'        => '01000353013',
                'address'       => 'ش الامام بن حنبل',
                'account_id'    => 100,
            ],
            [
                'name'          => 'محمود سامي',
                'email'         => 'ahmedray23es@gmail.com',
                'number'        => '01023353013',
                'address'       => 'ش 25 طه حسين',
                'account_id'    => 101,
            ]
        ]);
    }
}
