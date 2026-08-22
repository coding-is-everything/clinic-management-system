<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('primary_clinic_id')->nullable();
            $table->string('uhid', 80);
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say']);
            $table->string('blood_group', 10)->nullable();
            $table->string('marital_status', 50)->nullable();
            $table->string('occupation', 150)->nullable();
            $table->string('mobile', 30)->nullable();
            $table->string('alternate_mobile', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->enum('preferred_contact_method', ['sms', 'whatsapp', 'email', 'phone', 'portal'])->nullable();
            $table->string('preferred_language', 50)->nullable();
            $table->string('address_line1', 255)->nullable();
            $table->string('address_line2', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->nullable()->default('India');
            $table->string('government_id_type', 50)->nullable();
            $table->string('government_id_masked', 100)->nullable();
            $table->string('emergency_contact_name', 150)->nullable();
            $table->string('emergency_contact_relationship', 100)->nullable();
            $table->string('emergency_contact_mobile', 30)->nullable();
            $table->string('profile_photo', 500)->nullable();
            $table->enum('status', ['active', 'inactive', 'archived', 'merged'])->nullable()->default('active');
            $table->dateTime('registered_at');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->unique(['tenant_id', 'uhid'], 'uq_patient_uhid');
            $table->index(['tenant_id', 'mobile'], 'idx_patient_mobile');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('primary_clinic_id')->references('id')->on('clinics');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
