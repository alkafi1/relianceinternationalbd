<?php

use App\Enums\PartyStatusEnum;
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
        Schema::create('parties', function (Blueprint $table) {
            // Custom UID as primary key
            $table->uuid('uid')->primary();

            // Auto-increment primary key
            $table->string('party_id');
            $table->string('party_name', 256); 
            $table->string('email', 120)->unique(); // Unique email address
            $table->string('phone', 50)->nullable(); // Phone number (optional)
            $table->string('address', 256); // Member's address
            $table->enum('status', PartyStatusEnum::getValues())->default(PartyStatusEnum::APPROVED()->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
