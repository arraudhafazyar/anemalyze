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
        Schema::create('anamneses', function (Blueprint $table) {
            $table->id();
            $table->enum('kehamilan', ['Nulligravida', 'Primigravida', 'Multigravida']);
            $table->boolean('takikardia')->default(false);
            $table->boolean('hipertensi')->default(false);
            $table->boolean('transfusi_darah')->default(false);
            $table->enum('kebiasaan_merokok', ['Pasif', 'Aktif', 'Tidak merokok']);
            $table->text('keluhan');
            $table->foreignId('pasien_id')->constrained(
                table: 'pasiens',
                indexName: 'anamnesis_pasien_id'
            );          
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anamneses');
    }
};
