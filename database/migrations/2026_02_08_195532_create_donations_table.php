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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('full_name');
            $table->string('contact_number');
            $table->string('location');
            $table->string('category');
            $table->string('subcategory');
            $table->string('wearable_type')->nullable();
            $table->string('donation_photo')->nullable();
            $table->string('size')->nullable();
            $table->integer('quantity');
            $table->string('unit')->default('pieces'); // NEW: Add unit field
            $table->integer('available_quantity');
            $table->string('condition');
            $table->text('notes')->nullable();
            $table->string('specific_items')->nullable();
            $table->date('available_date');
            
            // NEW FIELDS FOR ADDITIONAL CATEGORIES
            $table->string('item_description')->nullable(); // For household, technology, etc.
            $table->string('accessories_included')->nullable(); // For technology
            $table->string('tested_functionality')->nullable(); // For technology
            $table->boolean('data_privacy_agreement')->default(false); // For technology
            $table->date('expiration_date')->nullable(); // For food/medical
            $table->boolean('is_anonymous')->default(false); // Anonymous donation
            
            $table->enum('status', ['pending', 'approved', 'rejected', 'claimed', 'matched', 'distributed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};