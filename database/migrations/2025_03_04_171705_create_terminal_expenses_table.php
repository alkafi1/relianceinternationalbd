<?php

use App\Enums\TerminalTypeEnum;
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
            $table->enum('job_type', TerminalTypeEnum::getValues())->default(TerminalTypeEnum::IMPORT()->value);
            $table->float('comission_rate')->nullable();
            $table->float('minimum_comission')->nullable();
            $table->enum('status', ['active', 'deactive'])->default('active');
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
        Schema::table('terminal_expenses', function (Blueprint $table) {
            $table->dropForeign(['terminal_id']);
        });

        // Drop the table
        Schema::dropIfExists('terminal_expenses');
    }
};
