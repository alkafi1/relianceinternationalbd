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
        Schema::create('job_expenses', function (Blueprint $table) {
            // Custom UID as primary key
            $table->uuid('uid')->primary();
            
            // Foreign key reference to terminals table
            $table->uuid('terminal_id');
            $table->foreign('terminal_id')->references('uid')->on('terminals')->onDelete('cascade');

            // Foreign key reference to terminal_expenses table
            $table->uuid('terminal_expense_id');
            $table->foreign('terminal_expense_id')->references('uid')->on('terminal_expenses')->onDelete('cascade');

            $table->string('job_expend_field', 256)->nullable();
            $table->integer('amount')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraints first (optional, but recommended)
        Schema::table('job_expenses', function (Blueprint $table) {
            $table->dropForeign(['terminal_expense_id']);
        });

        // Drop the table
        Schema::dropIfExists('job_expenses');
    }
};
