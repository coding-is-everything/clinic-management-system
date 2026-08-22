<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('encounter_vitals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('encounter_id');
            $table->decimal('height_cm', 6, 2)->nullable();
            $table->decimal('weight_kg', 6, 2)->nullable();
            $table->decimal('bmi', 5, 2)->nullable();
            $table->decimal('temperature_c', 5, 2)->nullable();
            $table->unsignedInteger('pulse_bpm')->nullable();
            $table->unsignedInteger('systolic_bp')->nullable();
            $table->unsignedInteger('diastolic_bp')->nullable();
            $table->decimal('spo2_percent', 5, 2)->nullable();
            $table->unsignedInteger('respiratory_rate')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('encounter_id')->references('id')->on('encounters');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('encounter_vitals');
    }
};
