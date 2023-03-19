<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
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
                'id'                 => LANDS_ACCOUNT,
                'name'               => 'الاراضي',
                'sub_account_id'     => SUB_FIXED_ASSETS,
            ],
            [
                'id'                 => BUILDING_ACCOUNT,
                'name'               => 'المباني',
                'sub_account_id'     => SUB_FIXED_ASSETS,
            ],
            [
                'id'                 => CARS_ACCOUNT,
                'name'               => 'السيارات',
                'sub_account_id'     => SUB_FIXED_ASSETS,
            ],
            [
                'id'                 => COMPLEX_DEPRECIATION_ACCOUNT,
                'name'               => 'مجمع الاهلاك',
                'sub_account_id'     => SUB_COMPLEX_DEPRECIATION,
            ],//end of fixed assets
            [
                'id'                 => MASTER_CASH_BOX_ACCOUNT,
                'name'               => 'الخزينة',
                'sub_account_id'     => CASH_BOX,
            ],
            [
                'id'                 => NOTE_RECEIVABLE_ACCOUNT,
                'name'               => 'اوراق قبض',
                'sub_account_id'     => NOTE_RECEIVABLE,
            ],
            [
                'id'                 => VISA_ACCOUNT,
                'name'               => 'فيزا',
                'sub_account_id'     => VISA,
            ],
            [
                'id'                 => CIB_BANK_ACCOUNT,
                'name'               => 'بنك CIB',
                'sub_account_id'     => BANKS,
            ],
            [
                'id'                 => ُEGYPT_BANK_ACCOUNT,
                'name'               => 'بنك مصر',
                'sub_account_id'     => BANKS,
            ],
            [
                'id'                 => CAIRO_BANK_ACCOUNT,
                'name'               => 'بنك القاهرة',
                'sub_account_id'     => BANKS,
            ],
            [
                'id'                 => BEGINNING_INVENTORY_ACCOUNT,
                'name'               => 'بضاعة اول المدة',
                'sub_account_id'     => BEGINNING_INVENTORY,
            ],
            [
                'id'                 => ENDING_INVENTORY_ACCOUNT,
                'name'               => 'بضاعة نهاية المدة',
                'sub_account_id'     => ENDING_INVENTORY,
            ],
            [
                'id'                 => MONTHLY_SAVE_ACCOUNT,
                'name'               => 'ادخار شهري',
                'sub_account_id'     => PREPAID_EXPENSES,
            ],//end of current assets
            [//sales
                'id'                 => SALES_ACCOUNT,
                'name'               => 'المبيعات',
                'sub_account_id'     => SALES,
            ],
            [
                'id'                 => PURCHASES_RETURNS_ACCOUNT,
                'name'               => 'مرتجع مشتريات',
                'sub_account_id'     => SUB_PURCHASES_RETURNS,
            ],
            [
                'id'                 => DISCOUNT_RECEIVED_ACCOUNT,
                'name'               => 'خصم مكتسب',
                'sub_account_id'     => SUB_DISCOUNT_RECEIVED,
            ],
            [
                'id'                 => OTHER_REVENUES_ACCOUNT,
                'name'               => 'ايرادات اخري ',
                'sub_account_id'     => SUB_OTHER_REVENUES,
            ],
            [
                'id'                 => OTHER_SELLING_ACCOUNT,
                'name'               => 'بيع كراتين',
                'sub_account_id'     => SUB_OTHER_REVENUES,
            ],//end of REVENUES
            [
                'id'                 => NOTES_PAYABLE_ACCOUNT,
                'name'               => 'اوراق دفع',
                'sub_account_id'     => NOTES_PAYABLE,
            ],
            [
                'id'                 => VALUE_ADDED_TAX_ACCOUNT,
                'name'               => 'ضريبة القيمة المضافة',
                'sub_account_id'     => TAX,
            ],
            [
                'id'                 => INCOME_TAX_ACCOUNT,
                'name'               => 'ضريبة الدخل',
                'sub_account_id'     => TAX,
            ],//end of CURRENT_LIABILITIES
            [
                'id'                 => CAPITAL_ACCOUNT,
                'name'               => 'راس المال',
                'sub_account_id'     => CAPITAL,
            ],
            [
                'id'                 => PROFIT_LOSS_ACCOUNT,
                'name'               => 'ارباح وخسائر',
                'sub_account_id'     => PROFIT_LOSS,
            ],//end of OWNER_EQUITY
            [
                'id'                 => PURCHASES_ACCOUNT,
                'name'               => 'مشتريات',
                'sub_account_id'     => SUB_PURCHASES,
            ],
            [
                'id'                 => SALES_RETURNS_ACCOUNT,
                'name'               => 'مرتجع بيعات',
                'sub_account_id'     => SUB_SALES_RETURNS,
            ],
            [
                'id'                 => DISCOUNT_ALLOWED_ACCOUNT,
                'name'               => 'خصم مسموح به',
                'sub_account_id'     => SUB_DISCOUNT_ALLOWED,
            ],
            [
                'id'                 => DAMAGED_GOODS_ACCOUNT,
                'name'               => 'بضاعة تالفة',
                'sub_account_id'     => SUB_DAMAGED_GOODS,
            ],
            [
                'id'                 => SALARIES_ACCOUNT,
                'name'               => 'مرتبات',
                'sub_account_id'     => SUB_MISCELLANEOUS_EXPENSES,
            ],
            [//incentives
                'id'                 => INCENTIVES_ACCOUNT,
                'name'               => 'حوافز',
                'sub_account_id'     => SUB_MISCELLANEOUS_EXPENSES,
            ],
            [//maintenance
                'id'                 => MAINTENANCE_ACCOUNT,
                'name'               => 'صيانة',
                'sub_account_id'     => SUB_MISCELLANEOUS_EXPENSES,
            ],
            [//petty cash
                'id'                 => PETTY_CASH_ACCOUNT,
                'name'               => 'مصاريف نثرية',
                'sub_account_id'     => SUB_MISCELLANEOUS_EXPENSES,
            ],
            [//transfers
                'id'                 => TRANSFER_EXPENSES_ACCOUNT,
                'name'               => 'انتقالات',
                'sub_account_id'     => SUB_MISCELLANEOUS_EXPENSES,
            ],
            [//rent
                'id'                 => RENT_EXPENSES_ACCOUNT,
                'name'               => 'ايجار',
                'sub_account_id'     => SUB_MISCELLANEOUS_EXPENSES,
            ],
            [//Banking expenses
                'id'                 => BANKING_EXPENSES_ACCOUNT,
                'name'               => 'مصروفات بنكية',
                'sub_account_id'     => SUB_MISCELLANEOUS_EXPENSES,
            ],
            [//Insurances
                'id'                 => INSURANCE_ACCOUNT,
                'name'               => 'تأمينات',
                'sub_account_id'     => SUB_MISCELLANEOUS_EXPENSES,
            ],
        ]);
    }
}
