<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoice_details', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('invoice_id');
            $table->string('barcode');
            $table->foreignId('product_id');
            $table->decimal('quantity',12,4,true);
            $table->decimal('price',12,4,true);
            $table->decimal('profit',12,4,false);
            $table->decimal('total_row',12,4,true);
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('invoice_id')->references('id')->on('sale_invoices')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_invoice_details');
    }
}
