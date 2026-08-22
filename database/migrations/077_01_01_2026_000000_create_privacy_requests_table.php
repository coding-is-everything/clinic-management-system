<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('privacy_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('request_type', 'ACCESS','EXPORT','CORRECTION','DELETION','RESTRICTION','CONSENT_WITHDRAWAL');
            $table->text('reason')->nullable();
            $table->string('status', 'REQUESTED','UNDER_REVIEW','APPROVED','REJECTED','COMPLETED')->nullable()->default('requested');
            $table->unsignedBigInteger('requested_by')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->dateTime('requested_at');
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('requested_by')->references('id')->on('users');
            $table->foreign('processed_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('privacy_requests');
    }
};
