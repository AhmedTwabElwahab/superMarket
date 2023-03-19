<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LaratrustSeeder::class,
            UsersTableSeeder::class,
            AccountTypeSeeder::class,
            MainAccountSeeder::class,
            SubAccountSeeder::class,
            AccountSeeder::class,
            ClientSeeder::class,
            SupplierSeeder::class,
            PaymentTypeSeeder::class,
            CategorySeeder::class,
            UnitSeeder::class,
            DocTypeSeeder::class,
            WarehouseSeeder::class,
            ProductSeeder::class,
            ReceiptTypeSeeder::class,

        ]);
    }
}
