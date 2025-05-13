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
        Schema::disableForeignKeyConstraints();

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('category')->index();
            $table->dateTime('date');
            $table->string('location');
            $table->string('poster_path')->nullable();
            $table->enum('status', ['pending', 'active', 'rejected', 'completed'])->default('pending');
            $table->decimal('ticket_price', 10, 2);
            $table->integer('ticket_quantity');
            $table->text('external_links')->nullable(); // YouTube, Spotify, dll
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
