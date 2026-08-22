<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('master_type', 100);
            $table->string('code', 100);
            $table->string('name', 200);
            $table->text('description')->nullable();
            $table->integer('sort_order')->nullable()->default(0);
            $table->enum('status', ['active', 'inactive'])->nullable()->default('active');
            $table->json('metadata')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'master_type', 'code'], 'uq_master');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_data');
    }
};
