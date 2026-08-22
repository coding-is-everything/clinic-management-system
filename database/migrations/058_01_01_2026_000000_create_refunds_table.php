<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->string('refund_no', 60);
            $table->dateTime('refund_date')->nullable();
            $table->decimal('amount', 14, 2);
            $table->string('refund_method', 'CASH','UPI','BANK_TRANSFER','CARD','OTHER');
            $table->text('reason');
            $table->string('status', 'REQUESTED','APPROVED','REJECTED','PROCESSED','CANCELLED')->nullable()->default('requested');
            $table->unsignedBigInteger('requested_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'refund_no'], 'uq_refund');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('requested_by')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
            $table->foreign('processed_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
