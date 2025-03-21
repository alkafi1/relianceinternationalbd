<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'users',
            'agents',
            'terminals',
            'parties',
            'system_contens',
            'terminal_expenses',
            'job_expenses',
            'reliance_jobs',
            'accounts',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('created_by_type', 50)->nullable()->after('updated_at');
                $table->string('created_by_uid', 50)->nullable()->after('created_by_type')
                    ->constrained('users')->nullOnDelete();

                $table->string('updated_by_type', 50)->nullable()->after('created_by_uid');
                $table->string('updated_by_uid', 50)->nullable()->after('updated_by_type')
                    ->constrained('users')->nullOnDelete();

                $table->string('deleted_by_type', 50)->nullable()->after('updated_by_uid');
                $table->string('deleted_by_uid', 50)->nullable()->after('deleted_by_type')
                    ->constrained('users')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'agents',
            'terminals',
            'parties',
            'terminal_expenses',
            'job_expenses',
            'reliance_jobs',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn([
                    'created_by_type',
                    'created_by_uid',
                    'updated_by_type',
                    'updated_by_uid',
                    'deleted_by_type',
                    'deleted_by_uid'
                ]);
            });
        }
    }
};
