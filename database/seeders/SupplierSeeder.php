<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
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
                'id'                => 200,
                'name'              => 'علي خشبة',
                'sub_account_id'    => SUPPLIERS_ACCOUNT,
            ],
            [
                'id'                => 201,
                'name'              => 'محمود برميل',
                'sub_account_id'    => SUPPLIERS_ACCOUNT,
            ]
        ]);
        DB::table('suppliers')->insert([
            [
                'name'          => 'علي خشبة',
                'email'         => 'ahmedrayes@gmail.com',
                'number'        => '01000353013',
                'address'       => 'ش الامام بن حنبل',
                'account_id'    => 200,
            ],
            [
                'name'          => 'محمود برميل',
                'email'         => 'ahmedray23es@gmail.com',
                'number'        => '01023353013',
                'address'       => 'ش 25 طه حسين',
                'account_id'    => 201,
            ]
        ]);
    }
}
