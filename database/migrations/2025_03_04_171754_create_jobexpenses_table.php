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
        
            // Foreign key reference to terminal_expenses table
            $table->foreignUuid('terminal_expense_id')
                  ->constrained('terminal_expenses', 'uid')
                  ->onDelete('cascade');
        
            $table->string('name', 256)->nullable();
            $table->integer('amount')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobexpenses');
    }
};
