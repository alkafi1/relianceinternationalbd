<?php

use App\Enums\AgentStatus;
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
        Schema::create('agents', function (Blueprint $table) {
            // Custom UID as primary key
            $table->uuid('uid')->primary(); // Use UUID for unique identifier

            // Agent ID (auto-incrementing)
            $table->string('agent_id');

            // Personal details
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('age')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();

            // Authentication details
            $table->string('password');

            // Base64-encoded image
            $table->longText('image')->nullable();

            // Address details
            $table->text('address')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('thana_id')->nullable();

            // Status (enum with default value)
            $table->enum('status', AgentStatus::getValues())->default(AgentStatus::APPROVED()->value);
            $table->softDeletes();
            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
