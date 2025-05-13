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
        Schema::create('e_tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('order_item_id')->index();
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('cascade');
            $table->string('code')->unique();
            $table->enum('status', ['active', 'used', 'cancelled', 'expired'])->default('active');
            $table->timestamp('accessed_at')->nullable();
            $table->string('accessed_by')->nullable();
            $table->string('access_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_tickets');
    }
};
