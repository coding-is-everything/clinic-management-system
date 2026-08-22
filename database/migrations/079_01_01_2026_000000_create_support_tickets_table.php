<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('ticket_no', 60);
            $table->string('subject', 255);
            $table->longText('description');
            $table->string('category', 100)->nullable();
            $table->string('priority', 'LOW','MEDIUM','HIGH','URGENT')->nullable()->default('medium');
            $table->string('status', 'OPEN','IN_PROGRESS','WAITING_CUSTOMER','RESOLVED','CLOSED')->nullable()->default('open');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->dateTime('opened_at');
            $table->dateTime('resolved_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['tenant_id', 'ticket_no'], 'uq_ticket');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('assigned_to')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
