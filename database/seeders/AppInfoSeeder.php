<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_info')->insert([
            'company_name'  => 'SuperMarket',
            'address'       => '....',
            'phone'         => '000',
            'whatsApp'      => '000',
            'currency'      => 'LE',
        ]);
    }
}
