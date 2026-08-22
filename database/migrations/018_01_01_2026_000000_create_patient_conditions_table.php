<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_conditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('condition_name', 200);
            $table->date('diagnosed_date')->nullable();
            $table->string('status', 'ACTIVE','CONTROLLED','RESOLVED','HISTORICAL','UNKNOWN')->nullable()->default('active');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('recorded_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_conditions');
    }
};
