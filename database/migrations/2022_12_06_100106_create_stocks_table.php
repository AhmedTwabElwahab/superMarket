<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id');
            $table->foreignId('product_id');
            $table->unsignedBigInteger('beginning_inventory')->default(0);
            $table->bigInteger('sold_quantity')->default(0);
            $table->bigInteger('sales_returns')->default(0);
            $table->bigInteger('purchases_returns')->default(0);
            $table->bigInteger('purchases_quantity')->default(0);
            $table->bigInteger('available')->default(0);



            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
};
