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
        Schema::create('bill_statements', function (Blueprint $table) {
            $table->uuid('uid')->primary();

            // Foreign key reference to terminals table
            $table->uuid('job_id');
            $table->foreign('job_id')->references('uid')->on('reliance_jobs')->onDelete('cascade');

            $table->string('bill_group');

            $table->string('party_id');

            $table->string('bill_id');

            $table->string('bill_date');

            $table->decimal('amount', 10, 2);
            $table->softDeletes();
            $table->string('created_by_type', 50)->nullable();
            $table->string('created_by_uid', 50)->nullable();

            $table->foreign('created_by_uid')->references('uid')->on('users')->onDelete('set null');

            $table->string('updated_by_type', 50)->nullable();
            $table->string('updated_by_uid', 50)->nullable();

            $table->foreign('updated_by_uid')->references('uid')->on('users')->onDelete('set null');

            $table->string('deleted_by_type', 50)->nullable();
            $table->string('deleted_by_uid', 50)->nullable();

            $table->foreign('deleted_by_uid')->references('uid')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_statements');
    }
};
