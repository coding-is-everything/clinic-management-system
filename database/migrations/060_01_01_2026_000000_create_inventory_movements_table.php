<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_item_id');
            $table->enum('movement_type', ['purchase', 'issue', 'return', 'adjustment', 'opening', 'writeoff']);
            $table->decimal('quantity_in', 12, 2)->nullable()->default(0);
            $table->decimal('quantity_out', 12, 2)->nullable()->default(0);
            $table->decimal('balance_quantity', 12, 2)->nullable()->default(0);
            $table->string('reference_type', 100)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('reason')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('created_at');
            $table->foreign('inventory_item_id')->references('id')->on('inventory_items');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
