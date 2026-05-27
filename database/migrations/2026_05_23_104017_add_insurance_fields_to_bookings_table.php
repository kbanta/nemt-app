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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('insurance_provider')->nullable()->after('payment_method');
            $table->string('insurance_member_id')->nullable()->after('insurance_provider');
            $table->string('insurance_group_number')->nullable()->after('insurance_member_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['insurance_provider', 'insurance_member_id', 'insurance_group_number']);
        });
    }
};
