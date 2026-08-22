<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_health_checks', function (Blueprint $table) {
            $table->id();
            $table->string('service_name', 150);
            $table->string('status', 'HEALTHY','DEGRADED','DOWN');
            $table->integer('response_time_ms')->nullable();
            $table->json('details')->nullable();
            $table->dateTime('checked_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_health_checks');
    }
};
