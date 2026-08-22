<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feature_usage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('feature_id');
            $table->date('usage_date');
            $table->unsignedBigInteger('usage_count')->nullable()->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'feature_id', 'usage_date'], 'uq_feature_usage');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('feature_id')->references('id')->on('features');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature_usage');
    }
};
