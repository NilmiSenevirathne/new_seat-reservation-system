<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reserve_id'); // custom PK name

            $table->unsignedBigInteger('intern_id'); // FK to users
            $table->unsignedBigInteger('seat_id');   // FK to seats

            $table->date('reservation_date');
            $table->string('time_slot', 20);
            $table->enum('status', ['active', 'cancelled'])->default('active');

            // FK constraints
            $table->foreign('intern_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seat_id')->references('seat_id')->on('seats')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
