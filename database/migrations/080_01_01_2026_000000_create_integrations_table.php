<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('name', 150);
            $table->string('provider', 100);
            $table->enum('integration_type', ['api', 'webhook', 'payment', 'messaging', 'email', 'storage', 'other']);
            $table->json('credentials_encrypted')->nullable();
            $table->json('configuration')->nullable();
            $table->enum('status', ['active', 'inactive', 'error', 'testing'])->nullable()->default('inactive');
            $table->dateTime('last_success_at')->nullable();
            $table->dateTime('last_error_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
