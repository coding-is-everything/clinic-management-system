<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investigation_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_item_id');
            $table->longText('result_text')->nullable();
            $table->json('result_json')->nullable();
            $table->text('interpretation')->nullable();
            $table->boolean('is_critical')->nullable()->default(false);
            $table->unsignedBigInteger('entered_by')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->dateTime('entered_at')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->enum('status', ['draft', 'entered', 'verified', 'released', 'amended'])->nullable()->default('draft');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('order_item_id')->references('id')->on('investigation_order_items');
            $table->foreign('entered_by')->references('id')->on('users');
            $table->foreign('verified_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investigation_results');
    }
};
