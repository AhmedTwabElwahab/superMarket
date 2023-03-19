<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'id'                => 1,
                'name'              => 'معجون اسنان',
                'purchase_price'    => 7.5,
                'sale_price'        => 15,
                'wholesale_price'   => 15,
                'half_price'        => 15,
                'unit_id'           => 1,
                'category_id'       => 1,
                'order_limit'      => 10,
            ],
            [
                'id'                => 2,
                'name'              => 'بلح',
                'purchase_price'    => 15.5,
                'sale_price'        => 30,
                'wholesale_price'   => 25,
                'half_price'        => 27,
                'unit_id'           => 1,
                'category_id'       => 1,
                'order_limit'      => 10,
            ],
        ]);


        DB::table('stocks')->insert([
            [
                'warehouse_id'            =>  MASTER_WAREHOUSE,
                'product_id'              =>  1,
                'available'               =>  17,
                'beginning_inventory'     =>  17,
            ],
            [
                'warehouse_id'            =>  MASTER_WAREHOUSE,
                'product_id'              =>  2,
                'available'               =>  50,
                'beginning_inventory'     =>  50,
            ],
        ]);


        DB::table('barcodes')->insert([
            [
                'product_id'           =>  1,
                'barcode'              =>  "564687987987469",
            ],
            [

                'product_id'           =>  2,
                'barcode'              =>  "2432487964684",
            ],
        ]);


    }
}
