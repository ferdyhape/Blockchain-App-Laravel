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
        // tabel category status pengajuan proyek,tabel ini akan berisi status seperti 'Proses Approval Komitee', 'Disetujui Komitee', 'Proses Tanda Tangan Kontrak', 'Proses Penggalangan Dana', dan 'Dibatalkan'
        Schema::create('category_project_submission_statuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 150);
            $table->string('icon', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_project_submission_statuses');
    }
};
