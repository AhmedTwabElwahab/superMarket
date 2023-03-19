<?php

/**
 * Start APP Settings
 */
const APP_PAGINATE                   = 50;
const APP_ERROR                      = -1;
const MASTER_WAREHOUSE               = 1;
const ALL_ACCOUNT                    = 113;
/**
 * End APP Settings
 */



/**
 * Start  ACCOUNT
 */

const LANDS_ACCOUNT                               = 1;
const BUILDING_ACCOUNT                            = 2;
const CARS_ACCOUNT                                = 3;
const COMPLEX_DEPRECIATION_ACCOUNT                = 4;
const MASTER_CASH_BOX_ACCOUNT                     = 5;
const NOTE_RECEIVABLE_ACCOUNT                     = 6;
const VISA_ACCOUNT                                = 7;
const CIB_BANK_ACCOUNT                            = 8;
const ُEGYPT_BANK_ACCOUNT                          = 9;
const CAIRO_BANK_ACCOUNT                          = 10;
const BEGINNING_INVENTORY_ACCOUNT                 = 11;
const ENDING_INVENTORY_ACCOUNT                    = 12;
const MONTHLY_SAVE_ACCOUNT                        = 13;
const SALES_ACCOUNT                               = 14;
const PURCHASES_RETURNS_ACCOUNT                   = 15;
const DISCOUNT_RECEIVED_ACCOUNT                   = 16;
const OTHER_REVENUES_ACCOUNT                      = 17;
const OTHER_SELLING_ACCOUNT                       = 18;
const NOTES_PAYABLE_ACCOUNT                       = 19;
const VALUE_ADDED_TAX_ACCOUNT                     = 20;
const INCOME_TAX_ACCOUNT                          = 21;
const CAPITAL_ACCOUNT                             = 22;
const PROFIT_LOSS_ACCOUNT                         = 23;
const SALES_RETURNS_ACCOUNT                       = 24;
const DISCOUNT_ALLOWED_ACCOUNT                    = 25;
const DAMAGED_GOODS_ACCOUNT                       = 26;
const SALARIES_ACCOUNT                            = 27;
const INCENTIVES_ACCOUNT                          = 28;
const MAINTENANCE_ACCOUNT                         = 29;
const PETTY_CASH_ACCOUNT                          = 30;
const TRANSFER_EXPENSES_ACCOUNT                   = 31;
const RENT_EXPENSES_ACCOUNT                       = 32;
const BANKING_EXPENSES_ACCOUNT                    = 33;
const INSURANCE_ACCOUNT                           = 34;
const PURCHASES_ACCOUNT                           = 35;

/**
 * END  ACCOUNT
 */




/**
 * Start SUB ACCOUNT
 */

const SUB_FIXED_ASSETS                   = 1;
const PREPAID_EXPENSES                   = 2;
const BEGINNING_INVENTORY                = 3;
const CASH_BOX                           = 4;
const NOTE_RECEIVABLE                    = 5;
const VISA                               = 6;
const RESERVATION_PAYMENTS               = 7;
const BANKS                              = 8;
const CLIENTS_ACCOUNT                    = 9;
const DEBTORS                            = 10;
const ENDING_INVENTORY                   = 11;
const SUPPLIERS_ACCOUNT                  = 12;
const SUB_SALES                          = 13;
const SUB_PURCHASES_RETURNS              = 14;
const SUB_DISCOUNT_RECEIVED              = 15;
const SUB_OTHER_REVENUES                 = 16;
const NOTES_PAYABLE                      = 17;
const TAX                                = 18;
const PARTNERS_CURRENT                   = 19;
const CAPITAL                            = 20;
const PROFIT_LOSS	                     = 21;
const SUB_OTHER_CREDIT_BALANCES          = 22;
const SUB_COMPLEX_DEPRECIATION           = 23;
const SUB_PURCHASES                      = 24;
const SUB_SALES_RETURNS                  = 25;
const SUB_DISCOUNT_ALLOWED               = 26;
const SUB_DEPRECIATION                   = 27;
const SUB_DAMAGED_GOODS                  = 28;
const SUB_MISCELLANEOUS_EXPENSES         = 29;



/**
 * END SUB ACCOUNT
 */

/**
* Start ACCOUNT TYPES
*/

const ASSETS_ACCOUNT          = 1;
const EXPENSES_ACCOUNT        = 2;
const REVENUES_ACCOUNT        = 3;
const LIABILITIES_ACCOUNT     = 4;
/**
* END ACCOUNT TYPES
*/

/**
 * Start MAIN ACCOUNT
 */
//ASSETS
const FIXED_ASSETS                = 1;
const CURRENT_ASSETS              = 2;
const OTHER_DEBIT_BALANCES        = 3;
//EXPENSES
const PURCHASES                   = 5;
const SALES_RETURNS               = 6;
const DISCOUNT_ALLOWED            = 7;
const DEPRECIATION                = 8;
const DAMAGED_GOODS               = 9;
const MISCELLANEOUS_EXPENSES      = 10;
//REVENUES
const SALES                       = 13;
const PURCHASES_RETURNS           = 14;
const DISCOUNT_RECEIVED           = 15;
const OTHER_REVENUES              = 16; // ايرادات اخري
//LIABILITIES
const CURRENT_LIABILITIES         = 17;//اوراق الدفع - الضرائب - اجل مورديين
const OTHER_CREDIT_BALANCES       = 18;
const OWNER_EQUITY                = 19;//حقوق الملكية


/**
 * END MAIN ACCOUNT
 */



/**
 * Start DOC Type
 */
const SALES_INVOICE                       = 1;
const PURCHASE_INVOICE                    = 2;
const SALES_RETURN                        = 3;
const PURCHASE_RETURN                     = 4;
const OPENING_BALANCE                     = 5;
const RECEIPT_IN                          = 6;
const RECEIPT_OUT                         = 7;


/**
 * End DOC Type
 */

/**
 * Start Payment Types Const
 */
const PAYMENT_CASH                    = 1;
const PAYMENT_CREDIT                  = 2;
const PAYMENT_VISA                    = 3;
/**
 * End Payment Types Const
 */

/**
 * Start transactions Type
 */
const TRAN_DEBIT                             = 11;
const TRAN_CREDIT                            = 12;
const TRAN_DEBIT_                            = -11;
const TRAN_CREDIT_                           = -12;
/**
 * End transactions Type
 */

/**
 * Start STOCK
 */
const STOCK_OUT                 = 1;
const STOCK_IN                  = 2;

/**
 * End STOCK
 */
