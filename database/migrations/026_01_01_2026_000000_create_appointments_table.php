<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('appointment_type_id');
            $table->string('appointment_no', 60);
            $table->string('token_no', 50)->nullable();
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('booking_source', ['reception', 'online', 'doctor', 'admin', 'phone', 'walk_in', 'api'])->nullable()->default('reception');
            $table->text('reason_for_visit')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['booked', 'confirmed', 'checked_in', 'waiting', 'called', 'in_consultation', 'completed', 'cancelled', 'no_show', 'rescheduled'])->nullable()->default('booked');
            $table->enum('payment_status', ['unpaid', 'partial', 'paid', 'refunded'])->nullable()->default('unpaid');
            $table->unsignedBigInteger('booked_by')->nullable();
            $table->dateTime('checked_in_at')->nullable();
            $table->dateTime('consultation_started_at')->nullable();
            $table->dateTime('consultation_completed_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'appointment_no'], 'uq_appt_no');
            $table->index(['doctor_id', 'appointment_date', 'start_time'], 'idx_appt_schedule');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('appointment_type_id')->references('id')->on('appointment_types');
            $table->foreign('booked_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
