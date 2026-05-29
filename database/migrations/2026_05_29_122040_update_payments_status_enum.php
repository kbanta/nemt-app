<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending','paid','failed','refunded','cancelled') NOT NULL DEFAULT 'pending'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending'");
        });
    }
};
