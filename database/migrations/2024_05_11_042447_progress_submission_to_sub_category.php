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
        Schema::table('progress_status_of_project_submissions', function (Blueprint $table) {
            $table->foreignUuid('sub_category_project_submission_id')
                ->after('category_project_submission_status_id')
                ->constrained('sub_category_project_submissions')
                ->index()
                ->name('sub_category_status_fk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress_status_of_project_submissions', function (Blueprint $table) {
            $table->dropForeign('sub_category_status_fk');
            $table->dropColumn('sub_category_project_submission_id');
        });
    }
};
