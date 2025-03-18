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
        Schema::create('reliance_job_expense_summuries', function (Blueprint $table) {
            $table->uuid('uid')->primary();

            // Foreign key reference to terminals table
            $table->uuid('job_id');
            $table->foreign('job_id')->references('uid')->on('reliance_jobs')->onDelete('cascade');

            $table->decimal('agency_commission', 10, 2);
            $table->decimal('total_expenses', 10, 2);
            $table->decimal('advanced_received', 10, 2);
            $table->decimal('due', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->string('created_by_type', 50)->nullable();
            $table->string('created_by_uid', 50)->nullable();

            $table->string('updated_by_type', 50)->nullable();
            $table->string('updated_by_uid', 50)->nullable();

            $table->string('deleted_by_type', 50)->nullable();
            $table->string('deleted_by_uid', 50)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reliance_job_expense_summuries');
    }
};
