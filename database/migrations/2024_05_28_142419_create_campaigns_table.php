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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('project_id')
                ->constrained('projects')->onDelete('cascade');
            $table->string('campaign_code')->unique();
            $table->decimal('approved_amount', 20, 2); // nominal disetujui
            $table->decimal('offered_token_amount', 20, 0); // jumlah token yang ditawarkan
            $table->decimal('price_per_unit', 20, 2); // harga per unit
            $table->decimal('minimum_purchase', 20, 0); // pembelian minimum
            $table->decimal('maximum_purchase', 20, 0); // pembelian maksimum
            $table->date('fundraising_period_start')->nullable(); // Fundraising period start
            $table->date('fundraising_period_end')->nullable(); // Fundraising period end
            $table->date('on_going_period_start')->nullable(); // On going period start
            $table->date('on_going_period_end')->nullable(); // On going period end
            $table->decimal('sold_token_amount', 20, 0)->default(0);
            $table->string('status')->default('pending'); // status proses penggalangan dana
            // dokumen prospektus akan di handle media library
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
