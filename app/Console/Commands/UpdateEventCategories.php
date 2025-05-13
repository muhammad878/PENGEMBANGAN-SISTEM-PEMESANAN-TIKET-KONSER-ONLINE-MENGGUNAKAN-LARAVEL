<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Str;

class UpdateEventCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:update-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all events with the correct category_id based on category name';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating events with correct category_id values...');
        
        // Get all events
        $events = Event::all();
        $categories = Category::all();
        
        $updated = 0;
        
        foreach ($events as $event) {
            if (!$event->category_id && $event->category) {
                // Try to find matching category
                $categoryName = $event->category;
                $categorySlug = Str::slug($categoryName);
                
                // Find by slug first
                $category = $categories->where('slug', $categorySlug)->first();
                
                // If not found, try to find by name
                if (!$category) {
                    $category = $categories->where('name', $categoryName)->first();
                }
                
                // If still not found, create a new category
                if (!$category) {
                    $category = Category::create([
                        'name' => ucwords($categoryName),
                        'slug' => $categorySlug,
                        'description' => 'Kategori konser ' . ucwords($categoryName),
                    ]);
                    
                    $categories->push($category);
                    $this->info("Created new category: {$category->name}");
                }
                
                // Update the event
                $event->category_id = $category->id;
                $event->save();
                
                $updated++;
                $this->info("Updated event '{$event->title}' with category: {$category->name}");
            }
        }
        
        $this->info("Completed! Updated {$updated} events.");
        
        return Command::SUCCESS;
    }
} 