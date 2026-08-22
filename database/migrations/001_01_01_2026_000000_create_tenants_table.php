<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('slug', 120);
            $table->string('code', 50);
            $table->string('email', 150)->nullable();
            $table->string('phone', 30)->nullable();
            $table->enum('status', ['trial', 'active', 'suspended', 'cancelled', 'archived'])->nullable()->default('trial');
            $table->string('timezone', 100)->nullable()->default('Asia/Kolkata');
            $table->string('locale', 20)->nullable()->default('en_IN');
            $table->char('currency', 3)->nullable()->default('INR');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
