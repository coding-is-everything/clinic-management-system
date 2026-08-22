<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_feature_overrides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('feature_id');
            $table->boolean('is_enabled')->nullable()->default(true);
            $table->decimal('limit_value', 14, 2)->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'feature_id'], 'uq_tenant_feature');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('feature_id')->references('id')->on('features');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_feature_overrides');
    }
};
