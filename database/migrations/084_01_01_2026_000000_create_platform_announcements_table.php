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
            $table->string('announcement_type', 'INFO','MAINTENANCE','WARNING','CRITICAL','RELEASE')->nullable()->default('info');
            $table->string('target_scope', 'ALL','SELECTED_TENANTS','SELECTED_ROLES')->nullable()->default('all');
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->string('status', 'DRAFT','SCHEDULED','PUBLISHED','EXPIRED','CANCELLED')->nullable()->default('draft');
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
