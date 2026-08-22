<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_imports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('import_type', 100);
            $table->string('file_name', 255);
            $table->string('file_path', 500);
            $table->unsignedInteger('total_rows')->nullable()->default(0);
            $table->unsignedInteger('valid_rows')->nullable()->default(0);
            $table->unsignedInteger('invalid_rows')->nullable()->default(0);
            $table->unsignedInteger('duplicate_rows')->nullable()->default(0);
            $table->enum('status', ['uploaded', 'validating', 'validated', 'processing', 'completed', 'failed', 'cancelled'])->nullable()->default('uploaded');
            $table->string('error_file_path', 500)->nullable();
            $table->unsignedBigInteger('imported_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('imported_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_imports');
    }
};
