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
        Schema::create('sub_category_project_submissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_project_submission_status_id')
                ->constrained('category_project_submission_statuses')
                ->index()
                ->name('category_status_fk');
            // $table->foreignUuid('sub_category_project_submission_id')
            //     ->after('category_project_submission_status_id')
            //     ->constrained('sub_category_project_submissions')
            //     ->index()
            //     ->name('sub_category_status_fk');
            $table->string('name');
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_category_project_submissions');
    }
};
