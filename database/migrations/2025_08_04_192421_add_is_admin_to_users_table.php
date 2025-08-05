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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom 'is_admin' setelah kolom 'email'
            // Tipe datanya boolean (hanya bisa true/1 atau false/0)
            // Nilai defaultnya adalah false, jadi setiap user baru otomatis menjadi user biasa
            $table->boolean('is_admin')->after('email')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Perintah ini akan dijalankan jika kita melakukan rollback migrasi
            // yaitu untuk menghapus kolom 'is_admin'
            $table->dropColumn('is_admin');
        });
    }
};