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
        Schema::create('purchase_invoices', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('warehouse_id');
            $table->foreignId('cash_box_id');
            $table->foreignId('supplier_id');
            $table->foreignId('payment_type_id');
            $table->string('num_invoice')->default(0);
            $table->decimal('total_bill',12,4,true);
            $table->decimal('discount',12,4,true);
            $table->decimal('amount_paid',12,4,true);
            $table->string('notes',255)->nullable();
            $table->foreignId('created_by');

            $table->timestamps();
            $table->softDeletes();


            $table->foreign('cash_box_id')->references('id')->on('accounts');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('purchase_invoices');
    }
};
