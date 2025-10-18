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
                Schema::create('recipient_requests', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                    
                    // Personal Information
                    $table->string('full_name');
                    $table->string('contact_number');
                    $table->string('address');
                    
                    // Request Details (Matching Donor Fields)
                    $table->string('category');
                    $table->string('subcategory');
                    $table->string('wearable_type')->nullable();
                    $table->string('size')->nullable();
                    $table->integer('quantity');
                    $table->string('unit')->default('pieces'); // NEW: Matching donor
                    $table->integer('remaining_quantity')->nullable();
                    $table->string('condition');
                    $table->text('description');
                    
                    // Additional Fields (Matching Donor)
                    $table->string('specific_items')->nullable();
                    $table->string('item_description')->nullable();
                    $table->string('accessories_included')->nullable();
                    $table->string('functionality_requirement')->nullable();
                    $table->string('expiration_preference')->nullable();
                    
                    // Urgency
                    $table->enum('urgency', ['asap', 'within_week', 'within_month', 'flexible'])->default('flexible');
                    
                    // Status Tracking
                    $table->enum('status', ['pending', 'approved', 'rejected', 'matched', 'partially_matched', 'fulfilled'])->default('pending');
                    $table->text('admin_notes')->nullable();
                    $table->timestamp('status_updated_at')->nullable();
                    
                    $table->timestamps();
                });
            }

            /**
             * Reverse the migrations.
             */
            public function down(): void
            {
                Schema::dropIfExists('recipient_requests');
            }
        };