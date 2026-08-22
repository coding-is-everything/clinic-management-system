<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platform_announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->longText('message');
            $table->enum('announcement_type', ['info', 'maintenance', 'warning', 'critical', 'release'])->nullable()->default('info');
            $table->enum('target_scope', ['all', 'selected_tenants', 'selected_roles'])->nullable()->default('all');
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'published', 'expired', 'cancelled'])->nullable()->default('draft');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_announcements');
    }
};
