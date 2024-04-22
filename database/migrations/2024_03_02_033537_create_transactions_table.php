<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transaction_code', 15)->unique();
            $table->string('buyer');
            $table->string('buyer_wallet_account_address', 50);
            $table->string('seller_company');
            $table->string('seller_wallet_account_address', 50);
            $table->integer('sum_of_product');
            $table->string('total_price');
            $table->string('payment_status')->default('pending');
            $table->string('payment_proof')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
