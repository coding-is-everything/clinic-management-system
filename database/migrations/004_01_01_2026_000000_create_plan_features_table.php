<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('feature_id');
            $table->boolean('is_enabled')->nullable()->default(true);
            $table->decimal('limit_value', 14, 2)->nullable();
            $table->string('limit_unit', 50)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['plan_id', 'feature_id'], 'uq_plan_feature');
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->foreign('feature_id')->references('id')->on('features');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_features');
    }
};
