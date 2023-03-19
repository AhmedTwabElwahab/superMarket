<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('main_accounts')->insert([
            [
                'id'       => FIXED_ASSETS,
                'type_id'  => ASSETS_ACCOUNT,
                'name'     => 'الاصول الثابتة',
            ],
            [
                'id'       => CURRENT_ASSETS,
                'type_id'  => ASSETS_ACCOUNT,
                'name'     => 'الاصول المتداولة',
            ],
            [
                'id'       => OTHER_DEBIT_BALANCES,
                'type_id'  => ASSETS_ACCOUNT,
                'name'     => 'ارصدة مدينة اخري',
            ],
            //end ASSETS
            [
                'id'       => PURCHASES,
                'type_id'  => EXPENSES_ACCOUNT,
                'name'     => 'مشتريات',
            ],
            [
                'id'       => SALES_RETURNS,
                'type_id'  => EXPENSES_ACCOUNT,
                'name'     => 'مرتجع بيع',
            ],
            [//Discount allowed
                'id'       => DISCOUNT_ALLOWED,
                'type_id'  => EXPENSES_ACCOUNT,
                'name'     => 'خصم مسموح به',
            ],
            [//Depreciation
                'id'       => DEPRECIATION,
                'type_id'  => EXPENSES_ACCOUNT,
                'name'     => 'اهلاك اصول ثابتة',
            ],
            [//Damaged goods
                'id'       => DAMAGED_GOODS,
                'type_id'  => EXPENSES_ACCOUNT,
                'name'     => 'بضاعة تالفة',
            ],
            [//Miscellaneous expenses
                'id'       => MISCELLANEOUS_EXPENSES,
                'type_id'  => EXPENSES_ACCOUNT,
                'name'     => 'مصروفات متنوعة',
            ],
            //end expenses
            [
                'id'       => SALES,
                'type_id'  => REVENUES_ACCOUNT,
                'name'     => 'مبيعات',
            ],
            [
                'id'       => PURCHASES_RETURNS,
                'type_id'  => REVENUES_ACCOUNT,
                'name'     => 'مرتجعات مشتريات',
            ],
            [//Discount Received
                'id'       => DISCOUNT_RECEIVED,
                'type_id'  => REVENUES_ACCOUNT,
                'name'     => 'خصم مكتسب',
            ],
            [
                'id'       => OTHER_REVENUES,
                'type_id'  => REVENUES_ACCOUNT,
                'name'     => 'ايرادات اخري',
            ],
            //end of revenues

            [
                'id'       => CURRENT_LIABILITIES,
                'type_id'  => LIABILITIES_ACCOUNT,
                'name'     => 'خصوم متداولة',
            ],
            [
                'id'       => OWNER_EQUITY,
                'type_id'  => LIABILITIES_ACCOUNT,
                'name'     => 'حقوق الملكية',
            ],
            [//Other credit balances
                'id'       => OTHER_CREDIT_BALANCES,
                'type_id'  => LIABILITIES_ACCOUNT,
                'name'     => 'ارصدة دائنة اخري',
            ],
            //end of liabilities
        ]);
    }
}
