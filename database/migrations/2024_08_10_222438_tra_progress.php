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
        Schema::create('tra_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('training_id');
            $table->foreign('student_id')->references('id')->on('std_student')->onDelete('cascade');
            $table->foreign('training_id')->references('id')->on('tra_training')->onDelete('cascade');
            $table->text('progress_description');
            $table->integer('progress_point');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tra_progress');
    }
};
