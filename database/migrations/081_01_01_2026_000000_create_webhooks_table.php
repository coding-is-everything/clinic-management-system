<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webhooks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->unsignedBigInteger('integration_id')->nullable();
            $table->string('event_code', 100);
            $table->string('endpoint_url', 500);
            $table->text('secret_encrypted')->nullable();
            $table->string('status', 'ACTIVE','INACTIVE')->nullable()->default('active');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('integration_id')->references('id')->on('integrations');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhooks');
    }
};
