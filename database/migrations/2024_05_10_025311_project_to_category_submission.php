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
        // foreign ini berfungsi untuk memberikan sampai mana status dari pengajuan proyek ini
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignUuid('category_project_submission_status_id')->after('project_category_id')->constrained('category_project_submission_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['category_project_submission_status_id']);
            $table->dropColumn('category_project_submission_status_id');
        });
    }
};
