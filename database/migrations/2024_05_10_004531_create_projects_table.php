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
        Schema::create('projects', function (Blueprint $table) {
            // dokumen pendukung akan dihandle media library
            // brosur katalog product akan di handle media library

            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->foreignUuid('project_category_id')->constrained('project_categories');
            $table->string('title', 100); // nama proyek
            $table->text('description'); // deskripsi proyek
            $table->decimal('nominal_required', 15, 2); // nominal yang dibutuhkan
            $table->longText('description_of_use_of_funds'); // deskripsi penggunaan dana
            $table->string('collateral_assets', 150); // aset jaminan
            $table->decimal('collateral_value', 15, 2); // nilai jaminan

            // lokasi tempat usaha
            $table->string('business_location_province_id');
            $table->string('business_location_city_id');
            $table->string('business_location_subdistrict_id');
            $table->string('details_of_business_location', 200);

            $table->decimal('income_per_month', 15, 2); // penghasilan per bulan
            $table->longText('projected_revenue_per_month'); // proyeksi pendapatan per bulan
            $table->decimal('expenses_per_month', 15, 2); // pengeluaran per bulan
            $table->longText('projected_monthly_expenses'); // proyeksi pengeluaran per bulan

            $table->string('income_statement_upload_every', 50); // upload laporan keuangan setiap (bulan)
            $table->longText('description_of_profit_sharing'); // deskripsi bagi hasil

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
