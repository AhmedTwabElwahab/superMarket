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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_box_id');
            $table->foreignId('account_id');
            $table->foreignId('type_id');
            $table->decimal('balance',12,4,true);
            $table->string('notes',255)->nullable();
            $table->foreignId('created_by');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('cash_box_id')->references('id')->on('accounts');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('type_id')->references('id')->on('receipt_types');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
};
