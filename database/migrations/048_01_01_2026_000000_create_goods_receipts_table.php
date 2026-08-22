<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('purchase_order_id');
            $table->string('grn_no', 60);
            $table->date('received_date');
            $table->string('status', 'DRAFT','CONFIRMED','CANCELLED')->nullable()->default('draft');
            $table->unsignedBigInteger('received_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'grn_no'], 'uq_grn');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->foreign('received_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};
