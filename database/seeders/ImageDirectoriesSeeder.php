<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ImageDirectoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder creates the necessary directories for storing event images.
     */
    public function run(): void
    {
        // Path for event images in public directory
        $eventsPath = public_path('images/events');
        
        // Create directories if they don't exist
        if (!File::exists($eventsPath)) {
            File::makeDirectory($eventsPath, 0755, true);
            $this->command->info('Created directory: ' . $eventsPath);
        } else {
            $this->command->info('Directory already exists: ' . $eventsPath);
        }
        
        // Path for category images
        $categoriesPath = public_path('images/categories');
        
        // Create category directories if they don't exist
        if (!File::exists($categoriesPath)) {
            File::makeDirectory($categoriesPath, 0755, true);
            $this->command->info('Created directory: ' . $categoriesPath);
        } else {
            $this->command->info('Directory already exists: ' . $categoriesPath);
        }
        
        // Create placeholder image for events
        $placeholderPath = $eventsPath . '/placeholder.jpg';
        if (!File::exists($placeholderPath)) {
            // Generate a simple placeholder image
            $this->generatePlaceholderImage($placeholderPath, "KonserKUY Event");
            $this->command->info('Created placeholder image: ' . $placeholderPath);
        } else {
            $this->command->info('Placeholder image already exists: ' . $placeholderPath);
        }
        
        // Create placeholder image for categories
        $categoryPlaceholderPath = $categoriesPath . '/placeholder.jpg';
        if (!File::exists($categoryPlaceholderPath)) {
            // Generate a simple placeholder image
            $this->generatePlaceholderImage($categoryPlaceholderPath, "KonserKUY Category");
            $this->command->info('Created category placeholder image: ' . $categoryPlaceholderPath);
        } else {
            $this->command->info('Category placeholder image already exists: ' . $categoryPlaceholderPath);
        }
    }
    
    /**
     * Generate a simple placeholder image
     */
    protected function generatePlaceholderImage($path, $text = "KonserKUY")
    {
        // Create a 800x600 image
        $image = imagecreatetruecolor(800, 600);
        
        // Allocate colors
        $bg = imagecolorallocate($image, 230, 240, 255);
        $text_color = imagecolorallocate($image, 50, 50, 200);
        
        // Fill the background
        imagefill($image, 0, 0, $bg);
        
        // Add text
        $font_size = 5;
        $text_width = imagefontwidth($font_size) * strlen($text);
        $text_height = imagefontheight($font_size);
        
        $x = (800 - $text_width) / 2;
        $y = (600 - $text_height) / 2;
        
        imagestring($image, $font_size, $x, $y, $text, $text_color);
        
        // Save the image
        imagejpeg($image, $path);
        
        // Free memory
        imagedestroy($image);
    }
} 