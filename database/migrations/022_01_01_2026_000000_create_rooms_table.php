<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->string('name', 100);
            $table->string('code', 50);
            $table->string('floor', 50)->nullable();
            $table->enum('room_type', ['consultation', 'procedure', 'diagnostic', 'pharmacy', 'other'])->nullable()->default('consultation');
            $table->enum('status', ['available', 'occupied', 'maintenance', 'blocked', 'closed'])->nullable()->default('available');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['clinic_id', 'code'], 'uq_room');
            $table->foreign('clinic_id')->references('id')->on('clinics');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
