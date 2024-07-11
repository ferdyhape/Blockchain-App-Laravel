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
        Schema::create('wallet_transaction_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('walletable_id');
            $table->string('walletable_type');
            $table->foreignUuid('payment_method_detail_id');
            $table->string('code');
            $table->string('status');
            $table->enum('type', ['topup', 'withdraw', 'withdraw_campaign', 'topup_campaign', 'profit_sharing_payment']);
            $table->string('payment_proof')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('amount', 16, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transaction_users');
    }
};
