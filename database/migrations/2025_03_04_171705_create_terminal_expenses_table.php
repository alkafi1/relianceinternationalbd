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
        Schema::create('terminal_expenses', function (Blueprint $table) {
            // Custom UID as primary key
            $table->uuid('uid')->primary();

            // Foreign key reference to terminals table
            $table->uuid('terminal_id');
            $table->foreign('terminal_id')->references('uid')->on('terminals')->onDelete('cascade');

            $table->string('title', 256);
            $table->integer('comission_rate')->nullable();
            $table->integer('minimum_comission')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminal_expenses');
    }
};
