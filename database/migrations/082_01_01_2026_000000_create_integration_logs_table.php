<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integration_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->unsignedBigInteger('integration_id')->nullable();
            $table->enum('direction', ['inbound', 'outbound']);
            $table->string('event_code', 100)->nullable();
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->integer('http_status')->nullable();
            $table->enum('status', ['success', 'failed', 'retrying']);
            $table->text('error_message')->nullable();
            $table->dateTime('created_at');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('integration_id')->references('id')->on('integrations');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integration_logs');
    }
};
