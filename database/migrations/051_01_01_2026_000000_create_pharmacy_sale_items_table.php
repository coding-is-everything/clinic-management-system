<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pharmacy_sale_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('medicine_id');
            $table->unsignedBigInteger('batch_id');
            $table->decimal('quantity', 12, 2);
            $table->decimal('unit_price', 14, 2);
            $table->decimal('discount_amount', 14, 2)->nullable()->default(0);
            $table->decimal('tax_amount', 14, 2)->nullable()->default(0);
            $table->decimal('total_amount', 14, 2)->nullable()->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('sale_id')->references('id')->on('pharmacy_sales');
            $table->foreign('medicine_id')->references('id')->on('medicines');
            $table->foreign('batch_id')->references('id')->on('medicine_batches');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pharmacy_sale_items');
    }
};
