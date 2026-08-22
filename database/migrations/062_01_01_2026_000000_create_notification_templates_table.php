<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('name', 150);
            $table->string('event_code', 100);
            $table->string('channel', 'SMS','WHATSAPP','EMAIL','IN_APP');
            $table->string('subject', 255)->nullable();
            $table->text('body');
            $table->json('variables')->nullable();
            $table->string('status', 'ACTIVE','INACTIVE')->nullable()->default('active');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
