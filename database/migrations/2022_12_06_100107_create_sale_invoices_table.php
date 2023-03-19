<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoices', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('warehouse_id');
            $table->foreignId('cash_box_id');
            $table->foreignId('client_id');
            $table->foreignId('payment_type_id');
            $table->decimal('discount',12,4,true);
            $table->decimal('amount_paid',12,4,true);
            $table->string('notes',255)->nullable();
            $table->decimal('total_bill');
            $table->foreignId('created_by');
            $table->softDeletes();

            $table->foreign('cash_box_id')->references('id')->on('accounts');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_invoices');
    }
}
