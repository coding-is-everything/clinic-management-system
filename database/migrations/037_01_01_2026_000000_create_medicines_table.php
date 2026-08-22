<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('name', 200);
            $table->string('generic_name', 200)->nullable();
            $table->string('brand_name', 200)->nullable();
            $table->string('medicine_code', 80);
            $table->string('dosage_form', 100)->nullable();
            $table->string('strength', 100)->nullable();
            $table->string('unit', 50)->nullable();
            $table->string('barcode', 100)->nullable();
            $table->string('manufacturer', 200)->nullable();
            $table->boolean('prescription_required')->nullable()->default(false);
            $table->enum('status', ['active', 'inactive'])->nullable()->default('active');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'medicine_code'], 'uq_medicine');
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
