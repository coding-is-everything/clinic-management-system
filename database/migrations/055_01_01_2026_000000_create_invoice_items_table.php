<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->string('description', 255);
            $table->decimal('quantity', 12, 2)->nullable()->default(1);
            $table->decimal('unit_price', 14, 2)->nullable()->default(0);
            $table->decimal('discount_amount', 14, 2)->nullable()->default(0);
            $table->decimal('tax_rate', 6, 2)->nullable()->default(0);
            $table->decimal('tax_amount', 14, 2)->nullable()->default(0);
            $table->decimal('total_amount', 14, 2)->nullable()->default(0);
            $table->string('source_type', 100)->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
