<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investigations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('name', 200);
            $table->string('code', 80);
            $table->string('specimen_type', 100)->nullable();
            $table->unsignedInteger('turnaround_minutes')->nullable();
            $table->decimal('price', 14, 2)->nullable()->default(0);
            $table->enum('status', ['active', 'inactive'])->nullable()->default('active');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'code'], 'uq_investigation');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('category_id')->references('id')->on('investigation_categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investigations');
    }
};
