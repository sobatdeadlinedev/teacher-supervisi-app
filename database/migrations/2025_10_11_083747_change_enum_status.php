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
        Schema::table('learning_administration_files', function (Blueprint $table) {
            // Mengubah enum status untuk menambahkan 'revision'
            $table->enum('status', ['waiting_approve', 'approved', 'rejected', 'revision'])
                ->default('waiting_approve')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_administration_files', function (Blueprint $table) {
            // Kembalikan enum status ke kondisi semula
            $table->enum('status', ['waiting_approve', 'approved', 'rejected'])
                ->default('waiting_approve')
                ->change();
        });
    }
};
