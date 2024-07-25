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
        Schema::create('lgn_login', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('username')->nullable(false);
            $table->string('password')->nullable(false);
            $table->unsignedInteger('id_coach')->nullable(false);
            $table->foreign('id_coach')->references('id')->on('coa_coach')->onDelete('cascade');
            $table->unsignedInteger('id_studant')->nullable(false);
            $table->foreign('id_studant')->references('id')->on('std_studant')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lgn_login');
    }
};
