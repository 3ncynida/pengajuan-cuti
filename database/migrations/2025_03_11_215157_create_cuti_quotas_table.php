<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuti_quotas', function (Blueprint $table) {
            $table->id('kuotacuti_id');
            $table->foreignId('karyawan_id')->constrained('karyawans', 'karyawan_id')->onDelete('cascade');
            $table->integer('jatah_masuk')->default(240); // Jatah hari kerja setahun
            $table->integer('sisa_jatah_masuk')->default(240); // Sisa hari kerja
            $table->integer('cuti_tahunan')->default(12);
            $table->integer('cuti_khusus')->default(3);
            $table->integer('cuti_haid')->default(12);
            $table->integer('cuti_melahirkan')->default(90);
            $table->integer('cuti_ayah')->default(30);
            $table->year('tahun');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuti_quotas');
    }
};
