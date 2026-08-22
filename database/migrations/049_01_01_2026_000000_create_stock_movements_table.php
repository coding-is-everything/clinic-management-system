<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('medicine_id')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->string('transaction_type', 'PURCHASE','SALE','DISPENSING','RETURN','DAMAGE','EXPIRY','ADJUSTMENT','OPENING','WRITEOFF');
            $table->string('reference_type', 100)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->decimal('quantity_in', 12, 2)->nullable()->default(0);
            $table->decimal('quantity_out', 12, 2)->nullable()->default(0);
            $table->decimal('balance_quantity', 12, 2)->nullable()->default(0);
            $table->decimal('unit_cost', 14, 2)->nullable()->default(0);
            $table->text('reason')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('created_at');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('medicine_id')->references('id')->on('medicines');
            $table->foreign('batch_id')->references('id')->on('medicine_batches');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
