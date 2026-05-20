<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kita tambah kolom guru_id untuk mencatat siapa guru walinya
            $table->unsignedBigInteger('guru_id')->nullable()->after('role');

            // Kita buat foreign key agar data guru_id ini nyambung ke ID di tabel users
            $table->foreign('guru_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
            $table->dropColumn('guru_id');
        });
    }
};