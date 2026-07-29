<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluarga_id')->constrained('keluarga')->cascadeOnDelete();
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']);
            $table->string('pekerjaan')->nullable();
            $table->enum('pendidikan_terakhir', ['Tidak/Belum Sekolah', 'Belum Tamat SD', 'SD', 'SLTP', 'SLTA', 'Diploma', 'S1', 'S2', 'S3']);
            $table->enum('status_dalam_keluarga', ['Kepala Keluarga', 'Istri', 'Anak', 'Famili Lain', 'Lainnya']);
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O'])->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
