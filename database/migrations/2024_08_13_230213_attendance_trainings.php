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
        Schema::create('attendance_training', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_id'); // Altere para unsignedBigInteger
            $table->unsignedBigInteger('training_id'); // Altere para unsignedBigInteger
            $table->foreign('attendance_id')->references('id')->on('atd_attendance')->onDelete('cascade');
            $table->foreign('training_id')->references('id')->on('tra_training')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_training');
    }
};
