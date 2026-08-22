<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('queue_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->string('token_no', 50);
            $table->date('queue_date');
            $table->string('priority', 'NORMAL','HIGH','URGENT','EMERGENCY')->nullable()->default('normal');
            $table->unsignedInteger('position')->nullable();
            $table->string('status', 'WAITING','CALLED','IN_CONSULTATION','COMPLETED','SKIPPED','NO_SHOW','CANCELLED','TRANSFERRED')->nullable()->default('waiting');
            $table->dateTime('check_in_at')->nullable();
            $table->dateTime('called_at')->nullable();
            $table->dateTime('recalled_at')->nullable();
            $table->dateTime('consultation_started_at')->nullable();
            $table->dateTime('consultation_completed_at')->nullable();
            $table->unsignedInteger('recall_count')->nullable()->default(0);
            $table->text('skip_reason')->nullable();
            $table->text('transfer_reason')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->index(['clinic_id', 'queue_date', 'doctor_id', 'status'], 'idx_queue');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('appointment_id')->references('id')->on('appointments');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queue_entries');
    }
};
