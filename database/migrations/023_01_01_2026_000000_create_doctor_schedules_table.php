<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedTinyInteger('day_of_week');
            $table->string('session_name', 100)->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('slot_duration_minutes')->nullable()->default(20);
            $table->unsignedInteger('buffer_minutes')->nullable()->default(0);
            $table->boolean('is_working')->nullable()->default(true);
            $table->date('effective_from')->nullable();
            $table->date('effective_until')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('clinic_id')->references('id')->on('clinics');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
