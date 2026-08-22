<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinic_holidays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->date('holiday_date');
            $table->string('name', 150);
            $table->string('status', 'ACTIVE','INACTIVE')->nullable()->default('active');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['clinic_id', 'holiday_date'], 'uq_holiday');
            $table->foreign('clinic_id')->references('id')->on('clinics');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_holidays');
    }
};
