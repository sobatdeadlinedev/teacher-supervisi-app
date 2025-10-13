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
        Schema::create('student_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('student_number', 50);
            $table->enum('journal_type', [
                'bangun_pagi',
                'beribadah',
                'olahraga',
                'makan_sehat',
                'belajar',
                'bermasyarakat',
                'tidur_cepat'
            ]);
            $table->date('journal_date');
            $table->json('journal_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_journals');
    }
};
