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
        Schema::create('published_projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('project_id')
                ->constrained('projects');
            $table->decimal('approved_amount', 20, 2); // nominal disetujui
            $table->decimal('offered_token_amount', 20, 2); // jumlah token yang ditawarkan
            $table->decimal('price_per_unit', 20, 2); // harga per unit
            $table->decimal('minimum_purchase', 20, 2); // pembelian minimum
            $table->decimal('maximum_purchase', 20, 2); // pembelian maksimum
            $table->date('fundraising_period_start')->nullable(); // Fundraising period start
            $table->date('fundraising_period_end')->nullable(); // Fundraising period end
            // dokumen prospektus akan di handle media library
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('published_projects');
    }
};
