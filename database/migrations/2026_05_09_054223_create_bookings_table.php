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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('service_type_id')->constrained();
            $table->string('pickup_address');
            $table->string('pickup_lat')->nullable();
            $table->string('pickup_lng')->nullable();
            $table->string('dropoff_address');
            $table->string('dropoff_lat')->nullable();
            $table->string('dropoff_lng')->nullable();
            $table->decimal('distance_miles', 8, 2)->nullable();
            $table->dateTime('scheduled_at');
            $table->text('notes')->nullable();
            $table->decimal('estimated_price', 10, 2)->default(0);
            $table->decimal('final_price', 10, 2)->default(0);
            $table->enum('status', ['pending', 'approved', 'assigned', 'in_transit', 'completed', 'cancelled'])->default('pending');
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
