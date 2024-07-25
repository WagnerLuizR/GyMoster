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
        Schema::create('std_studant', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('id_coach')->nullable();
            $table->foreign('id_coach')->references('id')->on('coa_coach')->onDelete('cascade');
            $table->unsignedInteger('id_training')->nullable();
            $table->foreign('id_training')->references('id')->on('tra_training')->onDelete('cascade');
            $table->string('nickname')->nullable();
            $table->string('age')->nullable();
            $table->decimal('height')->nullable();
            $table->decimal('weight')->nullable();
            $table->string('profile')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('std_studant');
    }
};
