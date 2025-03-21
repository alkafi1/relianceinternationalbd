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
        Schema::create('system_contens', function (Blueprint $table) {
            // Custom UID as primary key
            $table->uuid('uid')->primary();
            $table->string('name')->nullable(); // Required field
            $table->longText('content')->nullable(); // Long text field for content
            $table->string('media')->nullable(); // Media associated with the user
            $table->string('url')->nullable(); // URL associated with the user
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_contens');
    }
};
