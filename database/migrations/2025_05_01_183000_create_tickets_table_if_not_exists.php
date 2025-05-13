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
        if (!Schema::hasTable('tickets')) {
            Schema::create('tickets', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('event_id')->index();
                $table->string('ticket_type');
                $table->decimal('price', 10, 2);
                $table->integer('quota');
                $table->integer('sold')->default(0);
                $table->string('ticket_code')->unique();
                $table->dateTime('sale_start_date')->nullable();
                $table->dateTime('sale_end_date')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak menghapus tabel tickets karena mungkin sudah ada
    }
}; 