_table.php
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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_karyawan', 25)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('email', 25)->unique();
            $table->string('nohp', 20)->nullable()->unique();
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatans');
            $table->enum('role', ['admin', 'karyawan'])->default('karyawan');
            $table->string('password')->nullable();;
            $table->boolean('is_verified')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};