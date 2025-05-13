<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'K-Pop',
                'slug' => 'k-pop',
                'description' => 'Konser musik Korean Pop dengan penampilan dari artis dan grup populer Korea Selatan.',
                'image' => 'images/categories/kpop.jpg',
            ],
            [
                'name' => 'Pop',
                'slug' => 'pop',
                'description' => 'Konser musik pop internasional dan lokal dengan artis-artis ternama.',
                'image' => 'images/categories/pop.jpg',
            ],
            [
                'name' => 'Koplo',
                'slug' => 'koplo',
                'description' => 'Konser musik dangdut koplo dengan penampilan dari artis dan grup populer Indonesia.',
                'image' => 'images/categories/koplo.jpg',
            ],
            [
                'name' => 'Indie',
                'slug' => 'indie',
                'description' => 'Showcase dan konser dari musisi dan band indie yang menawarkan pengalaman musik unik.',
                'image' => 'images/categories/indie.jpg',
            ],
            [
                'name' => 'Classical',
                'slug' => 'classical',
                'description' => 'Konser musik klasik dengan orkestra, konduktor, dan solois berkelas dunia.',
                'image' => 'images/categories/classical.jpg',
            ],
            [
                'name' => 'Festival',
                'slug' => 'festival',
                'description' => 'Festival musik multi-hari dengan berbagai genre dan banyak artis di beberapa panggung.',
                'image' => 'images/categories/festival.jpg',
            ],
        ];

        // Masukkan data kategori ke database
        foreach ($categories as $category) {
            // Check if category already exists
            if (!Category::where('slug', $category['slug'])->exists()) {
                DB::table('categories')->insert([
                    'name' => $category['name'],
                    'slug' => $category['slug'],
                    'description' => $category['description'],
                    'image' => $category['image'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $this->command->info('Added category: ' . $category['name']);
            } else {
                $this->command->info('Category already exists: ' . $category['name']);
            }
        }
    }
} 