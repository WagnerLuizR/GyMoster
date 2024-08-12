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
        Schema::create('std_student', function (Blueprint $table) {
            $table->id();
            $table->string('nickname')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->decimal('height')->nullable();
            $table->decimal('weight')->nullable();
            $table->string('bmi')->nullable(); // IMC -> índice de maça corporal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('std_student');
    }
};
