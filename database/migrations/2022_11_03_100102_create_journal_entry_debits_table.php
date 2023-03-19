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
        Schema::create('journal_entry_debits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('balance');
            $table->foreignId('account_id');
            $table->foreignId('journal_id');

            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('journal_id')->references('id')->on('journals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_entry_debits');
    }
};
