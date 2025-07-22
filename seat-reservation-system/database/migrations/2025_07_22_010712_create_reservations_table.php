<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reserve_id'); // INT AUTO_INCREMENT PRIMARY KEY named reserve_id
            $table->unsignedBigInteger('intern_id');
            $table->unsignedBigInteger('seat_id');
            $table->date('reservation_date');
            $table->string('time_slot', 20);
            $table->enum('status', ['active', 'cancelled'])->default('active');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('intern_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('seat_id')->references('seat_id')->on('seats')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
