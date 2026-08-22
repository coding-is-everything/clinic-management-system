<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('numbering_sequences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->string('sequence_type', 100);
            $table->string('prefix', 30)->nullable();
            $table->unsignedBigInteger('current_number')->nullable()->default(0);
            $table->enum('reset_period', ['never', 'daily', 'monthly', 'yearly'])->nullable()->default('yearly');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'clinic_id', 'sequence_type'], 'uq_sequence');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('clinic_id')->references('id')->on('clinics');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('numbering_sequences');
    }
};
