<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_types')->insert([
            [   'id'    => PAYMENT_CASH,
                'name'  => 'كاش'
            ],
            [   'id'    => PAYMENT_CREDIT,
                'name'  => 'اجل'
            ],
            [   'id'    => PAYMENT_VISA,
                'name'  => 'فيزا'
            ]
        ]);
    }
}
