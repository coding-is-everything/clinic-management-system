<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_allergies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('allergen', 200);
            $table->string('reaction', 255)->nullable();
            $table->string('severity', 'MILD','MODERATE','SEVERE','CRITICAL')->nullable()->default('moderate');
            $table->string('status', 'ACTIVE','RESOLVED','HISTORICAL')->nullable()->default('active');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('recorded_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_allergies');
    }
};
