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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('total_Debit_balance',12,4,true)->default(0);
            $table->decimal('total_credit_balance',12,4,true)->default(0);
            $table->decimal('debit_balance',12,4,true)->default(0);
            $table->decimal('credit_balance',12,4,true)->default(0);
            $table->foreignId('sub_account_id');


            $table->timestamps();
            $table->foreignId('created_by')->nullable();


            $table->foreign('sub_account_id')->references('id')->on('sub_accounts');
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
        Schema::dropIfExists('accounts');
    }
};
