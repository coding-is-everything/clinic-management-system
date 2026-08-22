<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_booking_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->boolean('is_enabled')->nullable()->default(false);
            $table->unsignedInteger('advance_days')->nullable()->default(30);
            $table->boolean('same_day_enabled')->nullable()->default(true);
            $table->boolean('payment_required')->nullable()->default(false);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['clinic_id'], 'uq_online_booking_clinic');
            $table->foreign('clinic_id')->references('id')->on('clinics');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_booking_settings');
    }
};
