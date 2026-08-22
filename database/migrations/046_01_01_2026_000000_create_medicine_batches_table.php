<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicine_batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('medicine_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('batch_no', 100);
            $table->date('manufacturing_date')->nullable();
            $table->date('expiry_date');
            $table->decimal('purchase_price', 14, 2)->nullable()->default(0);
            $table->decimal('mrp', 14, 2)->nullable()->default(0);
            $table->decimal('selling_price', 14, 2)->nullable()->default(0);
            $table->decimal('received_quantity', 12, 2)->nullable()->default(0);
            $table->decimal('available_quantity', 12, 2)->nullable()->default(0);
            $table->decimal('reserved_quantity', 12, 2)->nullable()->default(0);
            $table->enum('status', ['active', 'blocked', 'expired', 'exhausted'])->nullable()->default('active');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'medicine_id', 'batch_no'], 'uq_batch');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('medicine_id')->references('id')->on('medicines');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicine_batches');
    }
};
