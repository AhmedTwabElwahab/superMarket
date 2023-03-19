<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_types')->insert([
            [
                'id'       => ASSETS_ACCOUNT,
                'name'     => 'الاصول',
            ],
            [
                'id'       => LIABILITIES_ACCOUNT,
                'name'     => 'الخصوم(الالتزامات)',
            ],
            [
                'id'       => REVENUES_ACCOUNT,
                'name'     => 'ايرادات',
            ],
            [
                'id'       => EXPENSES_ACCOUNT,
                'name'     => 'مصروفات',
            ],
        ]);
    }
}
