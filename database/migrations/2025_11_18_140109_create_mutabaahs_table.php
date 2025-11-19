<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mutabaahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggotas')->onDelete('cascade'); // Foreign key ke tabel anggotas
            $table->date('tanggal'); // Tanggal tilawah
            $table->string('nama_surat'); // Nama surat (e.g., Al-Baqarah)
            $table->integer('ayat_awal'); // Ayat awal
            $table->integer('ayat_akhir'); // Ayat akhir
            $table->text('keterangan')->nullable(); // Catatan tambahan (opsional)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutabaahs');
    }
};
