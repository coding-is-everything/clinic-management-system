<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investigation_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('encounter_id')->nullable();
            $table->string('order_no', 60);
            $table->dateTime('order_date');
            $table->enum('priority', ['routine', 'urgent', 'stat'])->nullable()->default('routine');
            $table->enum('status', ['ordered', 'sample_pending', 'sample_collected', 'processing', 'result_pending', 'completed', 'cancelled'])->nullable()->default('ordered');
            $table->text('notes')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'order_no'], 'uq_order_no');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('encounter_id')->references('id')->on('encounters');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investigation_orders');
    }
};
