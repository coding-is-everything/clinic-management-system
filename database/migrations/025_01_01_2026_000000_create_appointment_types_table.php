<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('name', 100);
            $table->string('code', 50);
            $table->unsignedInteger('duration_minutes')->nullable()->default(20);
            $table->decimal('fee', 14, 2)->nullable()->default(0);
            $table->integer('priority_level')->nullable()->default(0);
            $table->unsignedInteger('followup_valid_days')->nullable();
            $table->string('status', 'ACTIVE','INACTIVE')->nullable()->default('active');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'code'], 'uq_appt_type');
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_types');
    }
};
