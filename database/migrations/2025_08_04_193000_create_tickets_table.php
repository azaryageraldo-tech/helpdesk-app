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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // Kolom ID unik untuk setiap tiket
            $table->unsignedBigInteger('user_id'); // Kolom untuk ID pengguna yang membuat tiket
            $table->string('title'); // Judul tiket
            $table->text('description'); // Deskripsi lengkap masalah
            $table->string('status')->default('Open'); // Status tiket, default-nya 'Open'
            $table->string('priority')->default('Medium'); // Prioritas tiket, default-nya 'Medium'
            $table->timestamps(); // Kolom created_at dan updated_at

            // Membuat relasi (foreign key) ke tabel 'users'
            // Jika seorang user dihapus, semua tiketnya juga akan terhapus (onDelete('cascade'))
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};