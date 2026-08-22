<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('channel', 'SMS','WHATSAPP','EMAIL','IN_APP');
            $table->string('event_code', 100)->nullable();
            $table->string('recipient', 255);
            $table->string('subject', 255)->nullable();
            $table->text('body');
            $table->string('status', 'QUEUED','SENT','DELIVERED','FAILED','READ')->nullable()->default('queued');
            $table->string('provider_message_id', 255)->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->dateTime('read_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('patient_id')->references('id')->on('patients');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
