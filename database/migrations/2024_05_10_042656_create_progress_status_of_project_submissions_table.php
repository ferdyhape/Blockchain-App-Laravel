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
        // tabel ini akan berisi progress status dari project submission, yang di buat oleh owner project maupun admin
        Schema::create('progress_status_of_project_submissions', function (Blueprint $table) {
            // data ini akan digenerate otomatis oleh admin maupun owner project, untuk status submission maka ini di buat oleh owner project, sedangkan selain itu akan di buat oleh admin. untuk kemudian di tampilkan pada
            $table->uuid('id')->primary();
            $table->foreignUuid('project_id')->constrained('projects');
            $table->foreignUuid('category_project_submission_status_id')
                ->constrained('category_project_submission_statuses')
                ->index()
                ->name('category_status_fk');
            $table->mediumText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_status_of_project_submissions');
    }
};
