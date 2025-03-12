<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuti_quotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
            $table->integer('cuti_tahunan')->default(12); // 12 days per year
            $table->integer('cuti_khusus')->default(3);   // 3 days per year
            $table->integer('cuti_haid')->default(12);    // 1 day per month (12/year)
            $table->integer('cuti_melahirkan')->default(90); // 3 months
            $table->integer('cuti_ayah')->default(30);    // 1 month
            $table->year('tahun');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuti_quotas');
    }
};
