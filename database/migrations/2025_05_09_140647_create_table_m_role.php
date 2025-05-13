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
        Schema::create('m_role', function (Blueprint $table) {
            $table->id('id_role');
            $table->unsignedBigInteger('id_kriteria');
            $table->String('role_kode', 10)->unique();
            $table->String('role_name', 100);
            $table->timestamps();

            $table->foreign('id_kriteria')->references('id_kriteria')->on('m_kriteria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_role');
    }
};
