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
        Schema::create('supervisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('supervisor_id')->constrained('users')->onDelete('cascade');
            $table->date('schedule_date');
            $table->time('schedule_time')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->string('mata_pelajaran')->nullable();
            $table->string('kelas')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('supervision_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supervision_id')->constrained('supervisions')->onDelete('cascade');
            $table->enum('assessment_type', ['instrumen_penilaian', 'lembar_observasi', 'catatan_hasil']);
            $table->json('assessment_data');
            $table->timestamps();
        });

        Schema::create('supervision_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supervision_id')->constrained('supervisions')->onDelete('cascade');
            $table->text('feedback');
            $table->text('rekomendasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervision_feedbacks');
        Schema::dropIfExists('supervision_assessments');
        Schema::dropIfExists('supervisions');
    }
};
