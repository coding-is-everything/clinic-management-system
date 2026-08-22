<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_reschedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('old_doctor_id')->nullable();
            $table->date('old_date');
            $table->time('old_start_time');
            $table->time('old_end_time');
            $table->unsignedBigInteger('new_doctor_id')->nullable();
            $table->date('new_date');
            $table->time('new_start_time');
            $table->time('new_end_time');
            $table->text('reason')->nullable();
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->foreign('appointment_id')->references('id')->on('appointments');
            $table->foreign('old_doctor_id')->references('id')->on('doctors');
            $table->foreign('new_doctor_id')->references('id')->on('doctors');
            $table->foreign('changed_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_reschedules');
    }
};
