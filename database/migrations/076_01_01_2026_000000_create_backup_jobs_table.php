<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backup_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('backup_type', 'FULL','INCREMENTAL','DATABASE','FILES');
            $table->string('storage_path', 500)->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->string('checksum', 255)->nullable();
            $table->string('status', 'QUEUED','RUNNING','COMPLETED','FAILED','DELETED')->nullable()->default('queued');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_jobs');
    }
};
