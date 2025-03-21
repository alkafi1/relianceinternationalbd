<?php

use App\Enums\JobStatusEnum;
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
        Schema::create('reliance_jobs', function (Blueprint $table) {
            $table->uuid('uid')->primary(); // Auto-incrementing primary key

            // Foreign key reference to terminals table
            $table->uuid('terminal_id');
            $table->foreign('terminal_id')->references('uid')->on('terminals')->onDelete('cascade');
            
            $table->uuid('agent_id'); //Agent
            $table->foreign('agent_id')->references('uid')->on('agents')->onDelete('cascade');
            
            $table->uuid('party_id'); //party_id
            $table->foreign('party_id')->references('uid')->on('parties')->onDelete('cascade');
            
            $table->string('buyer_name'); // Buyer Name
            $table->string('invoice_no'); // Invoice No
            $table->decimal('value_usd', 10, 2); // Value (USD)
            $table->decimal('usd_rate', 10, 2); // USD Rate (in BDT)
            $table->string('item')->nullable(); // Item
            $table->string('lc_no')->nullable(); // L/C No
            $table->string('be_no')->nullable(); // B/E No
            $table->string('sales_contact')->nullable();
            $table->string('ud_no')->nullable(); // U/D No
            $table->string('ud_amendment_no')->nullable(); // U/D Amendment No
            $table->string('job_type'); // Job Type
            $table->string('master_bl_number')->nullable(); // Master Air Way Bill / BL Number
            $table->string('house_bl_number')->nullable(); // House Air Way Bill
            $table->integer('quantity'); // Quantity
            $table->integer('ctns_pieces')->nullable(); // CTNS Pieces
            $table->decimal('weight', 10, 2)->nullable(); // Weight
            $table->enum('status', [JobStatusEnum::getValues()]); // Status
            $table->decimal('voucher_amount', 10, 2); // Voucher Amount
            $table->string('job_no'); // Job No
            $table->softDeletes();
            $table->timestamps(); // Created At and Updated At timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reliance_jobs');
    }
};
