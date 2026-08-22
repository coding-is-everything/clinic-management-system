<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investigation_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('investigation_id');
            $table->decimal('price', 14, 2)->nullable()->default(0);
            $table->string('status', 'ORDERED','SAMPLE_PENDING','SAMPLE_COLLECTED','PROCESSING','RESULT_PENDING','COMPLETED','CANCELLED')->nullable()->default('ordered');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('order_id')->references('id')->on('investigation_orders');
            $table->foreign('investigation_id')->references('id')->on('investigations');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investigation_order_items');
    }
};
