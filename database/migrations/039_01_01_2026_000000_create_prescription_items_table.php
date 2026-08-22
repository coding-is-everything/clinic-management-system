<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_id');
            $table->unsignedBigInteger('medicine_id')->nullable();
            $table->string('medicine_name', 200);
            $table->string('dose', 100)->nullable();
            $table->string('frequency', 100)->nullable();
            $table->string('route', 100)->nullable();
            $table->string('duration', 100)->nullable();
            $table->decimal('quantity', 12, 2)->nullable();
            $table->text('instructions')->nullable();
            $table->string('timing', 100)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('prescription_id')->references('id')->on('prescriptions');
            $table->foreign('medicine_id')->references('id')->on('medicines');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
    }
};
