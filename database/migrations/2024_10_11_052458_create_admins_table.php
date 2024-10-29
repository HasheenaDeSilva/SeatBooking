<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('admin_id')->unique(); // Unique admin ID
            $table->string('admin_name'); // Admin name
            $table->string('email')->unique(); // Unique email
            $table->string('password'); // Hashed password
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins'); // Drop the admins table if it exists
    }
};