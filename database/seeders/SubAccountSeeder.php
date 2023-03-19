<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_accounts')->insert([
            [
                'id'                      => SUB_FIXED_ASSETS,
                'name'                    => 'اصول ثابتة',
                'main_account_id'         => FIXED_ASSETS,
            ],
            [//complex Depreciation
                'id'                      => SUB_COMPLEX_DEPRECIATION,
                'name'                    => 'مجمع الاهلاك',
                'main_account_id'         => FIXED_ASSETS,
            ],//end fixed assets
            [
                'id'                      => CASH_BOX,
                'name'                    => 'خزينة',
                'main_account_id'         => CURRENT_ASSETS,
            ],
            [
                'id'                      => NOTE_RECEIVABLE,
                'name'                    => 'اوراق قبض',
                'main_account_id'         => CURRENT_ASSETS,
            ],
            [
                'id'                      => VISA,
                'name'                    => 'فيزا',
                'main_account_id'         => CURRENT_ASSETS,
            ],
            [//reservation payments
                'id'                      => RESERVATION_PAYMENTS,
                'name'                    => 'دفعات حجز',
                'main_account_id'         => CURRENT_ASSETS,
            ],
            [
                'id'                      => BANKS,
                'name'                    => 'حسابات بنكية',
                'main_account_id'         => CURRENT_ASSETS,
            ],
            [
                'id'                      => CLIENTS_ACCOUNT,
                'name'                    => 'اجل عملاء',
                'main_account_id'         => CURRENT_ASSETS,
            ],
            [
                'id'                      => DEBTORS,
                'name'                    => 'حسابات مدينون',
                'main_account_id'         => CURRENT_ASSETS,
            ],
            [//Beginning Inventory
                'id'                      => BEGINNING_INVENTORY,
                'name'                    => 'بضاعة اول المدة',
                'main_account_id'         => CURRENT_ASSETS,
            ],
            [//Ending inventory
                'id'                      => ENDING_INVENTORY,
                'name'                    => 'بضاعة نهاية المدة',
                'main_account_id'         => CURRENT_ASSETS,
            ],
            [//Prepaid Expenses
                'id'                      => PREPAID_EXPENSES,
                'name'                    => 'مصروف معلق',
                'main_account_id'         => OTHER_DEBIT_BALANCES,
            ],//end of current assets

            [
                'id'                      => SUB_SALES,
                'name'                    => 'مبيعات',
                'main_account_id'         => SALES,
            ],
            [
                'id'                      => SUB_PURCHASES_RETURNS,
                'name'                    => 'مرتجع مشتريات',
                'main_account_id'         => PURCHASES_RETURNS,
            ],
            [
                'id'                      => SUB_DISCOUNT_RECEIVED,
                'name'                    => 'خصم مكتسب',
                'main_account_id'         => DISCOUNT_RECEIVED,
            ],
            [
                'id'                      => SUB_OTHER_REVENUES,
                'name'                    => 'ايرادات اخري',
                'main_account_id'         => OTHER_REVENUES,
            ],

            //start of CURRENT_LIABILITIES
            [//Notes Payable
                'id'                      => NOTES_PAYABLE,
                'name'                    => 'اوراق دفع',
                'main_account_id'         => CURRENT_LIABILITIES,
            ],
            [
                'id'                      => SUPPLIERS_ACCOUNT,
                'name'                    => 'المورديين',
                'main_account_id'         => CURRENT_LIABILITIES,
            ],
            [
                'id'                      => TAX,
                'name'                    => 'ضرائب',
                'main_account_id'         => CURRENT_LIABILITIES,
            ],
            //start of OWNER_EQUITY
            [//partners' current account(s)
                'id'                      => PARTNERS_CURRENT,
                'name'                    => 'حساب جاري شركاء',
                'main_account_id'         => OWNER_EQUITY,
            ],
            [//Capital
                'id'                      => CAPITAL,
                'name'                    => 'راس المال',
                'main_account_id'         => OWNER_EQUITY,
            ],
            [
                'id'                      => PROFIT_LOSS,
                'name'                    => 'ارباح وخسائر',
                'main_account_id'         => OWNER_EQUITY,
            ],
            [
                'id'                      => SUB_OTHER_CREDIT_BALANCES,
                'name'                    => 'ارصدة دائنة اخري',
                'main_account_id'         => OTHER_CREDIT_BALANCES,
            ],
            //start of expenses
            [
                'id'                      => SUB_PURCHASES,
                'name'                    => 'مشتريات',
                'main_account_id'         => PURCHASES,
            ],
            [
                'id'                      => SUB_SALES_RETURNS,
                'name'                    => 'مرتجع بيعات',
                'main_account_id'         => SALES_RETURNS,
            ],
            [
                'id'                      => SUB_DISCOUNT_ALLOWED,
                'name'                    => 'خصم مسموح به',
                'main_account_id'         => DISCOUNT_ALLOWED,
            ],
            [
                'id'                      => SUB_DEPRECIATION,
                'name'                    => 'اهلاك اصول ثابتة',
                'main_account_id'         => DEPRECIATION,
            ],
            [
                'id'                      => SUB_DAMAGED_GOODS,
                'name'                    => 'بضاعة تالفة',
                'main_account_id'         => DAMAGED_GOODS,
            ],
            [
                'id'                      => SUB_MISCELLANEOUS_EXPENSES,
                'name'                    => 'مصروفات ادارية وعمومية',
                'main_account_id'         => MISCELLANEOUS_EXPENSES,
            ],//end of expenses

        ]);
    }
}
