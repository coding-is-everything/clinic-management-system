<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('clinic_id');
            $table->string('name', 200);
            $table->string('item_code', 80);
            $table->string('category', 100)->nullable();
            $table->string('unit', 50)->nullable();
            $table->decimal('minimum_stock', 12, 2)->nullable()->default(0);
            $table->decimal('current_stock', 12, 2)->nullable()->default(0);
            $table->enum('status', ['active', 'inactive'])->nullable()->default('active');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'item_code'], 'uq_inventory_item');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('clinic_id')->references('id')->on('clinics');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
