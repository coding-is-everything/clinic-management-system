<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('name', 150);
            $table->string('email', 150)->nullable();
            $table->string('mobile', 30)->nullable();
            $table->string('username', 100)->nullable();
            $table->string('password', 255);
            $table->string('employee_code', 50)->nullable();
            $table->string('profile_photo', 500)->nullable();
            $table->enum('status', ['active', 'inactive', 'invited', 'pending', 'suspended', 'locked'])->nullable()->default('pending');
            $table->dateTime('email_verified_at')->nullable();
            $table->dateTime('mobile_verified_at')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->dateTime('password_changed_at')->nullable();
            $table->boolean('must_change_password')->nullable()->default(false);
            $table->boolean('mfa_enabled')->nullable()->default(false);
            $table->string('remember_token', 100)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->unique(['tenant_id', 'email'], 'uq_user_email');
            $table->unique(['tenant_id', 'username'], 'uq_user_username');
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
