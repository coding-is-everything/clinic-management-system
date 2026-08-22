<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('document_type', 100);
            $table->string('title', 255);
            $table->string('file_name', 255);
            $table->string('file_path', 500);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->unsignedInteger('version_no')->nullable()->default(1);
            $table->string('visibility', 'INTERNAL','DOCTOR','ADMIN','PATIENT')->nullable()->default('internal');
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('uploaded_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
