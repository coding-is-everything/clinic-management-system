<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('encounter_complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('encounter_id');
            $table->string('complaint', 255);
            $table->string('duration', 100)->nullable();
            $table->string('severity', 50)->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->foreign('encounter_id')->references('id')->on('encounters');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('encounter_complaints');
    }
};
