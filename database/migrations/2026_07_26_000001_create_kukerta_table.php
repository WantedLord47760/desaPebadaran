<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kukerta', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('konten');                  // Rich text (TinyMCE), like berita
            $table->json('pelaksana');                   // [{nama, nim, universitas}, ...]
            $table->string('kategori');
            $table->string('thumbnail')->nullable();     // Cover/thumbnail, like berita
            $table->json('foto_dokumentasi')->nullable();// ["path1", "path2", ...]
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['Perencanaan', 'Berjalan', 'Selesai'])->default('Selesai');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kukerta');
    }
};
