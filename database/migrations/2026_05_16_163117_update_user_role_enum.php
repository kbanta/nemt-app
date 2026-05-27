<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users 
            MODIFY role ENUM(
                'superadmin',
                'admin',
                'dispatcher',
                'driver',
                'client'
            ) NOT NULL DEFAULT 'client'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE users 
            MODIFY role ENUM(
                'admin',
                'driver',
                'client'
            ) NOT NULL DEFAULT 'client'
        ");
    }
};