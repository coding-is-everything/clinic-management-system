<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('module_code', 100);
            $table->string('name', 150);
            $table->string('code', 150);
            $table->text('description')->nullable();
            $table->string('risk_level', 'LOW','MEDIUM','HIGH','CRITICAL')->nullable()->default('low');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
