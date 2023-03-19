<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doc_types')->insert([
            [
                'id'   => SALES_INVOICE,
                'name' => 'فاتورة بيع',
            ],
            [
                'id'   => SALES_RETURN,
                'name' => 'مرتجع فاتورة بيع ',
            ],
            [
                'id'   => PURCHASE_INVOICE,
                'name' => 'فاتورة مشتريات',
            ],
            [
                'id'   => PURCHASE_RETURN,
                'name' => 'مرتجع فاتورة شراء',
            ],
            [
                'id'   => OPENING_BALANCE,
                'name' => 'رصيد اول المدة',
            ],
            [
                'id'   => RECEIPT_IN,
                'name' => 'ايصال استلام',
            ],
            [
                'id'   => RECEIPT_OUT,
                'name' => 'ايصال صرف ',
            ],
        ]);
    }
}
