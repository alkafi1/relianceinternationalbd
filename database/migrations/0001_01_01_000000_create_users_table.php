<?php

use App\Enums\AdminStatus;
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
        Schema::create('users', function (Blueprint $table) {
            // Custom UID as primary key
            $table->uuid('uid')->primary(); // Use UUID for unique identifier

            // User's first name
            $table->string('first_name');

            // User's last name
            $table->string('last_name');

            // User's email (unique)
            $table->string('email')->unique();

            // Timestamp for email verification (nullable)
            $table->timestamp('email_verified_at')->nullable();

            // User status with predefined values: 'active', 'delete', 'approved', 'unapproved', 'suspended', 'lock'
            $table->enum('status', AdminStatus::getValues())->default(AdminStatus::APPROVED()->value);

            // User's password (hashed)
            $table->string('password');

            // Base64-encoded image
            $table->longText('image')->nullable(); // Store Base64-encoded image

            // Remember token for "remember me" functionality
            $table->rememberToken();
            
            $table->softDeletes();
            // Timestamps for created_at and updated_at
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
