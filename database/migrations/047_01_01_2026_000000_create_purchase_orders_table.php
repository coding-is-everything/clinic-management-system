<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('po_no', 60);
            $table->date('order_date');
            $table->date('expected_date')->nullable();
            $table->decimal('subtotal', 14, 2)->nullable()->default(0);
            $table->decimal('discount_amount', 14, 2)->nullable()->default(0);
            $table->decimal('tax_amount', 14, 2)->nullable()->default(0);
            $table->decimal('total_amount', 14, 2)->nullable()->default(0);
            $table->string('status', 'DRAFT','CREATED','SENT','PARTIALLY_RECEIVED','RECEIVED','CANCELLED')->nullable()->default('draft');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'po_no'], 'uq_po');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
