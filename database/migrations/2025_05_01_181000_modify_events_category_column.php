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
        // Hanya jalankan jika tabel events sudah ada
        if (Schema::hasTable('events')) {
            // Hapus foreign key constraints jika ada
            try {
                Schema::table('events', function (Blueprint $table) {
                    if (Schema::hasColumn('events', 'category')) {
                        $table->dropIndex(['category']);
                    }
                });
            } catch (\Exception $e) {
                // Abaikan error jika index tidak ada
            }

            // Ubah kolom category menjadi string biasa
            Schema::table('events', function (Blueprint $table) {
                if (Schema::hasColumn('events', 'category')) {
                    $table->string('category')->index()->change();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu melakukan apa-apa
    }
}; 