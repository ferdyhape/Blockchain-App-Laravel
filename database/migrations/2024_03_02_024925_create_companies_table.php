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
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 100);
            $table->longText('description');
            $table->string('address');
            $table->string('logo');
            $table->string('city', 100);
            $table->string('country', 100);
            $table->string('phone', 20);
            $table->integer('employee_count');
            $table->string('established_year', 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
