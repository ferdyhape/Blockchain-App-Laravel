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

            $table->string('transaction_code')->unique(); // kode transaksi

            $table->uuid('campaign_id'); // id campaign
            $table->string('campaign_name'); // nama campaign

            $table->uuid('from_to_user_id'); // user id yang melakukan transaksi
            $table->string('from_to_user_name'); // nama user yang melakukan transaksi

            $table->string('order_type'); // tipe order (buy/sell)
            $table->enum('payment_status', ['paid', 'unpaid', 'failed'])->default('unpaid'); // status pembayaran (paid/unpaid/failed)

            $table->enum('status', ['pending', 'success', 'failed'])->default('pending'); // status transaksi (pending/success/failed)

            $table->uuid('payment_method_id'); // id metode pembayaran
            $table->string('payment_method'); // metode pembayaran (Bank Transfer, Wallet Saldo)

            $table->uuid('payment_method_detail_id'); // id detail metode pembayaran (Bank Mandiri, Bank BCA, Your Wallet Saldo)
            $table->string('payment_method_detail'); // detail metode pembayaran (Bank Mandiri, Bank BCA, Your Wallet Saldo)

            $table->string('payment_proof')->nullable(); // bukti pembayaran

            $table->integer('quantity')->default(1); // jumlah token yang dibeli
            $table->decimal('total_price', 20, 2); // total harga transaksi

            $table->timestamps();
            // kolom status ini dipengaruhi oleh kolom payment_status, jika payment_status = paid maka status = success, jika payment_status = unpaid maka status = pending, jika payment_status = failed maka status = failed (durasi 2*24 jam)
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
