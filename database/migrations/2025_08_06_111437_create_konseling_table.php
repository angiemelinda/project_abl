<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonselingTable extends Migration
{
    public function up(): void
    {
        Schema::create('konseling', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');      // relasi ke user yang mengajukan
            $table->unsignedBigInteger('konselor_id');  // relasi ke konselor
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('nomor_telepon');
            $table->text('deskripsi');  // bisa untuk isi masalah, keluhan, dll
            $table->dateTime('jadwal')->nullable();     // default null, nanti dijadwalkan oleh konselor
            $table->string('topik')->nullable();
            $table->enum('status', ['menunggu', 'dijadwalkan', 'selesai', 'batal'])->default('menunggu');
            $table->text('catatan')->nullable();        // catatan hasil konseling
            $table->timestamps();

            // opsional: foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('konselor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konseling');
    }
}
