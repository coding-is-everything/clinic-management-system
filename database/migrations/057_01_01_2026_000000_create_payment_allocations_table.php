<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_allocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->decimal('amount', 14, 2);
            $table->dateTime('created_at')->nullable();
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('invoice_id')->references('id')->on('invoices');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_allocations');
    }
};
