<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('category_id');
            $table->string('name')->unique();
            $table->foreignId('unit_id');
            $table->decimal('purchase_price',12,4,true)->default(0);
            $table->decimal('sale_price',12,4,true);
            $table->decimal('wholesale_price',12,4,true)->default(0);
            $table->decimal('half_price',12,4,true)->default(0);
            $table->date('expiry_date')->nullable();
            $table->unsignedBigInteger('order_limit',false)->default(0);
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
