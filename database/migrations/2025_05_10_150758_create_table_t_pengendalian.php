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
        Schema::create('t_pengendalian', function (Blueprint $table) {
            $table->id('id_pengendalian');
            $table->unsignedBigInteger('id_kriteria')->index();
            $table->text('pengendalian')->nullable();
            $table->string('pendukung')->nullable();
            $table->timestamps();

            $table->foreign('id_kriteria')->references('id_kriteria')->on('m_kriteria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pengendalian');
    }
};
