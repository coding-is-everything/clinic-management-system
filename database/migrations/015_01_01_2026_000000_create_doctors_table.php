<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('primary_clinic_id')->nullable();
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('display_name', 200);
            $table->string('gender', 'MALE','FEMALE','OTHER','PREFER_NOT_TO_SAY')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('mobile', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->text('bio')->nullable();
            $table->decimal('years_experience', 5, 1)->nullable();
            $table->unsignedBigInteger('primary_specialization_id')->nullable();
            $table->string('registration_number', 100)->nullable();
            $table->string('registration_council', 150)->nullable();
            $table->string('registration_state', 100)->nullable();
            $table->date('registration_date')->nullable();
            $table->date('registration_expiry_date')->nullable();
            $table->string('verification_status', 'PENDING','VERIFIED','REJECTED','EXPIRED')->nullable()->default('pending');
            $table->string('status', 'DRAFT','ACTIVE','INACTIVE','SUSPENDED')->nullable()->default('draft');
            $table->string('signature_path', 500)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('primary_clinic_id')->references('id')->on('clinics');
            $table->foreign('primary_specialization_id')->references('id')->on('specializations');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
