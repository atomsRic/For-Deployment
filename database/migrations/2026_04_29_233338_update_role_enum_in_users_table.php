<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: First update ALL non-admin roles to 'student' BEFORE altering the column
        DB::statement("UPDATE users SET role = 'admin' WHERE role = 'admin'");
        DB::statement("UPDATE users SET role = 'student' WHERE role != 'admin'");

        // Step 2: Now safe to change the enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'student') NOT NULL DEFAULT 'student'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'member') NOT NULL DEFAULT 'member'");
        DB::statement("UPDATE users SET role = 'member' WHERE role = 'student'");
    }
};