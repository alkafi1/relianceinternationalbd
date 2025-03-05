<?php

use App\Enums\AccountTypeEnum;
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
        Schema::create('accounts', function (Blueprint $table) {
            // Custom UID as primary key
            $table->uuid('uid')->primary();
            $table->uuid('account_holder_uid')->nullable(); // Polymorphic ID
            $table->string('account_holder_type')->nullable(); // Polymorphic type (e.g., App\Models\Party, App\Models\User, App\Models\Agent)
            $table->string('account_name', 256)->nullable();
            $table->enum('account_type', AccountTypeEnum::getValues())->nullable();
            $table->float('current_balance')->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
