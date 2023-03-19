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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->string('name')->unique();
            $table->string('email')->nullable();
            $table->string('number',20)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('whatsApp',20)->nullable();
            $table->text('address')->nullable();
            //TODO:is_Supplier
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
