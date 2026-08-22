<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Wire the `clinics` table into the application's real multi-tenancy
     * mechanism (Fortify teams). The `tenant_id`/`tenants` columns from the
     * original ClinicOS schema are not populated by anything in the app —
     * `team_id` is the FK that `{current_team}`-scoped routes actually use.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE clinics MODIFY tenant_id BIGINT UNSIGNED NULL');

        Schema::table('clinics', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->after('tenant_id')->constrained()->cascadeOnDelete();
            $table->unique(['team_id', 'code'], 'uq_clinic_team');
        });
    }

    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            $table->dropUnique('uq_clinic_team');
            $table->dropConstrainedForeignId('team_id');
        });

        DB::statement('ALTER TABLE clinics MODIFY tenant_id BIGINT UNSIGNED NOT NULL');
    }
};
