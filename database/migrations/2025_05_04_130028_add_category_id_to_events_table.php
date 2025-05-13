<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Event;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('category')->constrained();
        });

        // Populate category_id based on existing category string
        $events = DB::table('events')->get();
        foreach ($events as $event) {
            if ($event->category) {
                $category = DB::table('categories')->where('slug', $event->category)->first();
                if ($category) {
                    DB::table('events')
                        ->where('id', $event->id)
                        ->update(['category_id' => $category->id]);
                } else {
                    // If the category doesn't exist, create it
                    $categoryId = DB::table('categories')->insertGetId([
                        'name' => ucwords($event->category),
                        'slug' => $event->category,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    
                    DB::table('events')
                        ->where('id', $event->id)
                        ->update(['category_id' => $categoryId]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
    }
};
