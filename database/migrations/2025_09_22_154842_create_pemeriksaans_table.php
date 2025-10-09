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
        Schema::create('pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->integer('heart_rate');
            $table->integer('spo2');
            $table->enum('status_anemia', ['Anemia', 'Normal']);
            $table->foreignId('pasien_id')->constrained(
                table: 'pasiens',
                indexName: 'pemeriksaan_pasien_id'
            );
            $table->foreignId('anamnesis_id')->unique()->constrained(
                table: 'anamneses',
                indexName: 'pemeriksaan_anamnesis_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaans');
    }
};
