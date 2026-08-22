<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 50);
            $table->text('description')->nullable();
            $table->decimal('monthly_price', 14, 2)->nullable()->default(0);
            $table->decimal('yearly_price', 14, 2)->nullable()->default(0);
            $table->char('currency', 3)->nullable()->default('INR');
            $table->unsignedInteger('trial_days')->nullable()->default(0);
            $table->string('status', 'ACTIVE','INACTIVE','ARCHIVED')->nullable()->default('active');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
