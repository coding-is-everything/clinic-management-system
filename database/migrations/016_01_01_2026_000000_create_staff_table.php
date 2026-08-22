<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('employee_code', 50)->nullable();
            $table->string('designation', 150)->nullable();
            $table->date('joining_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->nullable()->default('active');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
