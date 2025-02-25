<?php

use App\Enums\TerminalStatusEnum;
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
        Schema::create('terminals', function (Blueprint $table) {
            // Custom UID as primary key
            $table->uuid('uid')->primary(); // Use UUID for unique identifier

            // Auto-increment primary key
            $table->string('terminal_id');

            // Terminal name, maximum length of 256 characters
            $table->string('terminal_name', 256);

            // Terminal short form (optional), maximum length of 15 characters
            $table->string('terminal_short_form', 15)->nullable();

            // Description for the terminal, maximum length of 512 characters
            $table->string('description', 512);

            // Terminal type (1=Both, 2=Import, 3=Export), default value is 1 (Both)
            $table->enum('terminal_type', TerminalTypeEnum::getValues())->default(TerminalTypeEnum::BOTH()->value);

            // Address, maximum length of 256 characters
            $table->string('address', 256);

            // Status of the terminal (0=Delete, 1=Active, 2=Deactive), default value is 1 (Active)
            $table->enum('status', TerminalStatusEnum::getValues())->default(TerminalStatusEnum::ACTIVE()->value);

            // Automatically adds 'created_at' and 'updated_at' timestamps for tracking
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminals');
    }
};
