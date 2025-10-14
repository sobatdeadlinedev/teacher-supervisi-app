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
        Schema::create('wali_kelas_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wali_kelas_id');
            $table->unsignedBigInteger('siswa_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('wali_kelas_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('siswa_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_kelas_siswa');
    }
};
