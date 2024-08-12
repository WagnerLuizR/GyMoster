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
        Schema::create('tra_training', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->enum('difficult_level', ['i', 'in', 'a'])->nullable(); // 0 = Iniciante; 1 = Intermediario; 2 = Avançado;
            $table->time('duration')->nullable(); // média de tempo de duração do treino
            $table->enum('type', ['a', 'c', 'm', 'tf', 'tfx', 'tai', 'tc', 'tm']); // tipo de treino - ex: Cardio, musculação, alongamento, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tra_training');
    }
};
