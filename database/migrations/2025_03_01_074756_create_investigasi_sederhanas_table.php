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
        Schema::create('investigasi_sederhana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kepala_id')->constrained('users');
            $table->foreignId('insiden_id')->constrained('insiden');
            $table->text('penyebab_insiden');
            $table->text('penyebab_melatarbelakangi');

            $table->text('rekomendasi');
            $table->foreignId('penanggung_jawab_rekomendasi')->constrained('users');
            $table->date('tanggal_rekomendasi');

            $table->text('tindakan_rekomendasi');
            $table->foreignId('penanggung_jawab_tindakan')->constrained('users');
            $table->date('tanggal_tindakan');

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->enum('lengkap', ['lengkap', 'belum']);
            $table->enum('investigasi_lanjut', ['ya', 'tidak']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investigasi_sederhana');
    }
};
