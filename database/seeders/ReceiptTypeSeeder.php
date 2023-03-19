<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiptTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('receipt_types')->insert([
            [
                'id'   => RECEIPT_IN,
                'name' => 'ايصال استلام نقدية'
            ],
            [
                'id'   => RECEIPT_OUT,
                'name' => 'ايصال صرف نقدية'
            ],

        ]);
    }
}
