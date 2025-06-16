<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('root_cause_analysis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ketua_id');
            $table->foreignId('insiden_id');
            $table->foreignId('notulen_id')->nullable()->default(null);
            $table->foreignId('kepala_igd_id')->nullable()->default(null);
            $table->tinyInteger('area_terwakili');
            $table->tinyInteger('pengetahuan_terwakili');
            $table->date('tanggal_mulai_investigasi');
            $table->date('tanggal_selesai_dilengkapi')->nullable()->default(null);
            $table->json('members')->nullable()->default(null);
            $table->json('data_primer')->nullable()->default(null);
            $table->json('data_sekunder')->nullable()->default(null);
            $table->json('data_lainnya')->nullable()->default(null);
            $table->json('kronologi_waktu_kejadian')->nullable()->default(null);
            $table->json('identifikasi_masalah')->nullable()->default(null);
            $table->json('rekomendasi')->nullable()->default(null);
            $table->json('perubahan_dan_penghalang')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('root_cause_analysis');
    }
};
