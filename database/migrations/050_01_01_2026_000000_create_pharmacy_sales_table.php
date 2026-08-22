<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pharmacy_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('prescription_id')->nullable();
            $table->string('sale_no', 60);
            $table->dateTime('sale_date');
            $table->decimal('subtotal', 14, 2)->nullable()->default(0);
            $table->decimal('discount_amount', 14, 2)->nullable()->default(0);
            $table->decimal('tax_amount', 14, 2)->nullable()->default(0);
            $table->decimal('total_amount', 14, 2)->nullable()->default(0);
            $table->string('status', 'DRAFT','COMPLETED','CANCELLED','REFUNDED','PARTIAL_REFUND')->nullable()->default('draft');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'sale_no'], 'uq_sale');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('prescription_id')->references('id')->on('prescriptions');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pharmacy_sales');
    }
};
