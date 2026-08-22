<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('setting_group', 100);
            $table->string('setting_key', 150);
            $table->json('setting_value')->nullable();
            $table->boolean('is_sensitive')->nullable()->default(false);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'setting_group', 'setting_key'], 'uq_system_setting');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
