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
        Schema::create('donation_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('recipient_requests')->onDelete('cascade');
            $table->foreignId('donation_id')->constrained('donations')->onDelete('cascade');
            $table->integer('allocated_quantity'); // How much from this donation was allocated to this request
            $table->enum('status', ['pending', 'approved', 'completed', 'cancelled'])->default('approved');
            $table->text('admin_notes')->nullable();
            $table->timestamp('matched_at')->useCurrent();
            $table->timestamps();
            
            // Prevent duplicate matches
            $table->unique(['request_id', 'donation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_matches');
    }
};
