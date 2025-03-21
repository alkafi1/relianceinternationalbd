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
        Schema::create('bill_registers', function (Blueprint $table) {
            $table->uuid('uid')->primary();

            // Foreign key reference to terminals table
            $table->uuid('job_id');
            $table->foreign('job_id')->references('uid')->on('reliance_jobs');

            $table->string('party_id');
            $table->foreign('party_id')->references('uid')->on('parties');

            $table->string('job_no');

            $table->string('bill_no');

            $table->decimal('bill_amount', 10, 2);

            $table->string('bill_date');

            $table->decimal('received_amount')->default(0.00);

            $table->string('received_date')->nullable();

            $table->decimal('due_amount')->default(0.00);

            $table->string('remarks');

            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_registers');
    }
};
