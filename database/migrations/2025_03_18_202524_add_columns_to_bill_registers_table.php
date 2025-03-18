<?php

use App\Enums\JobTypeEnum;
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
        Schema::table('bill_registers', function (Blueprint $table) {
            $table->enum('job_type', JobTypeEnum::getValues())->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bill_registers', function (Blueprint $table) {
            $table->dropColumn('job_type');
        });
    }
};
