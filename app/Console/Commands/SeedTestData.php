<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SeedTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:test-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed test data for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Seeding test data...');

        // Create default users if they don't exist
        $this->createUsers();
        
        // Create categories if they don't exist
        $this->createCategories();
        
        // Create events
        $this->createEvents();
        
        $this->info('Test data seeded successfully!');
        
        return Command::SUCCESS;
    }
    
    /**
     * Create default users.
     */
    private function createUsers()
    {
        $this->info('Creating users...');
        
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'name' => 'Event Organizer',
                'email' => 'eo@example.com',
                'password' => Hash::make('password'),
                'role' => 'eo',
                'status' => 'active',
            ],
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
            ],
        ];
        
        foreach ($users as $userData) {
            $user = User::where('email', $userData['email'])->first();
            
            if (!$user) {
                User::create(array_merge($userData, [
                    'email_verified_at' => now(),
                ]));
                $this->info("Created user: {$userData['email']}");
            } else {
                $this->info("User already exists: {$userData['email']}");
            }
        }
    }
    
    /**
     * Create categories.
     */
    private function createCategories()
    {
        $this->info('Creating categories...');
        
        $categories = [
            [
                'name' => 'K-Pop',
                'slug' => 'k-pop',
                'description' => 'Konser musik Korean Pop dengan penampilan dari artis dan grup populer Korea Selatan.',
            ],
            [
                'name' => 'Pop',
                'slug' => 'pop',
                'description' => 'Konser musik pop internasional dan lokal dengan artis-artis ternama.',
            ],
            [
                'name' => 'Rock',
                'slug' => 'rock',
                'description' => 'Konser musik rock dengan energi tinggi dari band-band rock lokal dan internasional.',
            ],
            [
                'name' => 'Jazz',
                'slug' => 'jazz',
                'description' => 'Konser dan festival jazz dengan penampilan dari musisi jazz ternama.',
            ],
            [
                'name' => 'Electronic',
                'slug' => 'electronic',
                'description' => 'Festival dan konser musik elektronik dengan DJ dan produser music ternama.',
            ],
            [
                'name' => 'Indie',
                'slug' => 'indie',
                'description' => 'Showcase dan konser dari musisi dan band indie yang menawarkan pengalaman musik unik.',
            ],
            [
                'name' => 'Classical',
                'slug' => 'classical',
                'description' => 'Konser musik klasik dengan orkestra, konduktor, dan solois berkelas dunia.',
            ],
            [
                'name' => 'Festival',
                'slug' => 'festival',
                'description' => 'Festival musik multi-hari dengan berbagai genre dan banyak artis di beberapa panggung.',
            ],
        ];
        
        foreach ($categories as $categoryData) {
            $category = Category::where('slug', $categoryData['slug'])->first();
            
            if (!$category) {
                Category::create(array_merge($categoryData, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
                $this->info("Created category: {$categoryData['name']}");
            } else {
                $this->info("Category already exists: {$categoryData['name']}");
            }
        }
    }
    
    /**
     * Create events.
     */
    private function createEvents()
    {
        $this->info('Creating events...');
        
        // Get all categories
        $categories = Category::all();
        
        // Get Event Organizer user ID (assume it's ID 2, but check first)
        $organizer = User::where('role', 'eo')->first();
        if (!$organizer) {
            $this->error('Event Organizer user not found');
            return;
        }
        
        $organizerId = $organizer->id;
        
        $events = [
            [
                'title' => 'Blackpink World Tour 2023: Born Pink in Jakarta',
                'description' => 'Experience the global phenomenon BLACKPINK live in Jakarta for their "Born Pink" world tour! This high-energy concert will feature their biggest hits including "Pink Venom," "DDU-DU DDU-DU," "How You Like That," and many more. With stunning choreography, impressive stage setups, and their signature charisma, BLACKPINK promises an unforgettable night for all BLINKs!',
                'category' => 'K-Pop',
                'date' => Carbon::now()->addDays(30)->setHour(19)->setMinute(30),
                'location' => 'Gelora Bung Karno Stadium, Jakarta',
                'status' => 'active',
                'ticket_price' => 1500000,
                'ticket_quantity' => 50000,
            ],
            [
                'title' => 'Coldplay: Music of the Spheres World Tour',
                'description' => 'Coldplay brings their spectacular "Music of the Spheres" world tour to Indonesia for the first time! Experience Chris Martin and the band perform their greatest hits along with tracks from their latest album in an environmentally conscious show featuring incredible visuals, light shows, and interactive elements.',
                'category' => 'Pop',
                'date' => Carbon::now()->addDays(45)->setHour(20)->setMinute(0),
                'location' => 'Gelora Bung Karno Stadium, Jakarta',
                'status' => 'active',
                'ticket_price' => 1800000,
                'ticket_quantity' => 40000,
            ],
            [
                'title' => 'Ed Sheeran: Mathematics Tour',
                'description' => 'Join the Grammy-winning singer-songwriter Ed Sheeran as he brings his "Mathematics Tour" to Jakarta. Experience his chart-topping hits like "Shape of You," "Perfect," and "Bad Habits" in an intimate solo performance featuring his signature loop pedal and acoustic guitar.',
                'category' => 'Pop',
                'date' => Carbon::now()->addDays(60)->setHour(19)->setMinute(0),
                'location' => 'Indonesia Convention Exhibition (ICE), BSD City',
                'status' => 'active',
                'ticket_price' => 1350000,
                'ticket_quantity' => 25000,
            ],
            [
                'title' => 'BTS Reunion Special: Map of the Soul',
                'description' => 'The moment all ARMY has been waiting for! Experience the emotional reunion of all seven BTS members after their military service for this exclusive world tour. Witness RM, Jin, Suga, J-Hope, Jimin, V, and Jungkook perform their biggest hits together on stage once again!',
                'category' => 'K-Pop',
                'date' => Carbon::now()->addDays(90)->setHour(18)->setMinute(30),
                'location' => 'Gelora Bung Karno Stadium, Jakarta',
                'status' => 'active',
                'ticket_price' => 2000000,
                'ticket_quantity' => 60000,
            ],
            [
                'title' => 'Tame Impala: Slow Rush Tour',
                'description' => 'Australian psychedelic music project Tame Impala (Kevin Parker) brings their mesmerizing "Slow Rush Tour" to Indonesia for the first time. Experience their hypnotic sounds, mind-bending visuals, and dreamy atmosphere in this immersive concert experience.',
                'category' => 'Indie',
                'date' => Carbon::now()->addDays(55)->setHour(20)->setMinute(0),
                'location' => 'Beach City International Stadium, Ancol',
                'status' => 'active',
                'ticket_price' => 1250000,
                'ticket_quantity' => 15000,
            ],
            [
                'title' => 'Java Jazz Festival 2023',
                'description' => 'Indonesia\'s premiere jazz event returns with an incredible lineup of international and local jazz artists. Experience three days of smooth sounds, improvisation, and musical excellence across multiple stages in this world-renowned festival.',
                'category' => 'Jazz',
                'date' => Carbon::now()->addDays(75)->setHour(16)->setMinute(0),
                'location' => 'JIExpo Kemayoran, Jakarta',
                'status' => 'active',
                'ticket_price' => 1500000,
                'ticket_quantity' => 30000,
            ],
        ];
        
        foreach ($events as $eventData) {
            // Check if the event already exists
            $exists = Event::where('title', $eventData['title'])->exists();
            if ($exists) {
                $this->info("Event already exists: {$eventData['title']}");
                continue;
            }
            
            // Find the category
            $category = $categories->firstWhere('name', $eventData['category']);
            if (!$category) {
                $this->error("Category not found: {$eventData['category']}");
                continue;
            }
            
            $slug = Str::slug($eventData['title']);
            
            Event::create([
                'user_id' => $organizerId,
                'title' => $eventData['title'],
                'slug' => $slug,
                'description' => $eventData['description'],
                'category' => Str::slug($eventData['category']),
                'category_id' => $category->id,
                'date' => $eventData['date'],
                'location' => $eventData['location'],
                'status' => $eventData['status'],
                'ticket_price' => $eventData['ticket_price'],
                'ticket_quantity' => $eventData['ticket_quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $this->info("Created event: {$eventData['title']}");
        }
    }
}
