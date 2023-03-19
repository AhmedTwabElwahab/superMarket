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
        Schema::create('purchase_invoice_details', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('invoice_id');
            $table->string('barcode');
            $table->foreignId('product_id');
            $table->decimal('quantity',12,4,true);
            $table->decimal('price',12,4,true);
            $table->decimal('total_row',12,4,true);

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('invoice_id')->references('id')->on('purchase_invoices')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_invoice_details');
    }
};
