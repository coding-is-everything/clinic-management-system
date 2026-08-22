<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('encounter_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('encounter_id');
            $table->unsignedBigInteger('diagnosis_id')->nullable();
            $table->string('diagnosis_name', 200);
            $table->enum('diagnosis_type', ['primary', 'secondary', 'provisional', 'confirmed', 'rule_out', 'historical']);
            $table->text('notes')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->foreign('encounter_id')->references('id')->on('encounters');
            $table->foreign('diagnosis_id')->references('id')->on('diagnoses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('encounter_diagnoses');
    }
};
