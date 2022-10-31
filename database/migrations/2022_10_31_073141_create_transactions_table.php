<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // transaction
/*
    id
    user_id
    transaction_type
    amount
    phone_number
    payment_method
    trx_id -> nullable
    isApprove
*/
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string("transaction_type");
            $table->string("amount");
            $table->string("phone_number");
            $table->string("payment_method");
            $table->string("trx_id")->nullable();
            $table->string("isApprove")->default('0');
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
        Schema::dropIfExists('transactions');
    }
}
