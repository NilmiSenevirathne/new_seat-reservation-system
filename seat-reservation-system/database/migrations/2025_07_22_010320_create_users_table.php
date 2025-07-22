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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // INT AUTO_INCREMENT PRIMARY KEY named user_id
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('role', ['intern', 'admin']);
            $table->timestamps();  // Optional, add if you want created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
