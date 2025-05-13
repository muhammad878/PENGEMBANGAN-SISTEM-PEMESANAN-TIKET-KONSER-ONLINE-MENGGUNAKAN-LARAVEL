<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ViewConcertData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'konser:view {--categories : Tampilkan kategori saja} {--populate : Populate data if empty}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tampilkan data konser yang sudah dimasukkan ke database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('populate')) {
            return $this->populateData();
        }
        
        if ($this->option('categories')) {
            $this->viewCategories();
        } else {
            $this->viewEvents();
        }

        return 0;
    }

    /**
     * View categories in table
     */
    private function viewCategories()
    {
        $categories = Category::withCount('events')->get();
        
        if ($categories->isEmpty()) {
            $this->error('Belum ada data kategori di database.');
            if ($this->confirm('Apakah Anda ingin menambahkan data kategori?')) {
                $this->populateCategories();
                $categories = Category::withCount('events')->get();
            } else {
                return;
            }
        }
        
        $this->info('Data Kategori');
        $this->table(
            ['ID', 'Nama', 'Slug', 'Deskripsi', 'Jumlah Konser', 'Dibuat'],
            $categories->map(function($category) {
                return [
                    $category->id,
                    $category->name,
                    $category->slug,
                    Str::limit($category->description, 30),
                    $category->events_count,
                    $category->created_at,
                ];
            })
        );
    }

    /**
     * View events in table
     */
    private function viewEvents()
    {
        $events = Event::with('user')->get();
        
        if ($events->isEmpty()) {
            $this->error('Belum ada data konser di database.');
            if ($this->confirm('Apakah Anda ingin menambahkan data konser?')) {
                $this->populateEvents();
                $events = Event::with('user')->get();
            } else {
                return;
            }
        }
        
        $this->info('Data Konser');
        $this->table(
            ['ID', 'Judul', 'Kategori', 'Lokasi', 'Tanggal', 'Status', 'Harga Tiket'],
            $events->map(function($event) {
                return [
                    $event->id,
                    $event->title,
                    $event->category,
                    $event->location,
                    $event->date->format('d M Y H:i'),
                    $event->status,
                    'Rp ' . number_format($event->ticket_price, 0, ',', '.'),
                ];
            })
        );
    }
    
    /**
     * Populate database with sample data
     */
    private function populateData()
    {
        // Check if categories exist
        if (Category::count() == 0) {
            $this->populateCategories();
        } else {
            $this->info('Kategori sudah ada di database.');
        }
        
        // Check if events exist
        if (Event::count() == 0) {
            $this->populateEvents();
        } else {
            $this->info('Konser sudah ada di database.');
        }
        
        $this->info('Selesai menambahkan data.');
        return 0;
    }
    
    /**
     * Populate categories
     */
    private function populateCategories()
    {
        $this->info('Menambahkan data kategori...');
        
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
                'name' => 'Rock',
                'slug' => 'rock',
                'description' => 'Konser musik rock dengan energi tinggi dari band-band rock lokal dan internasional.',
                'image' => 'images/categories/rock.jpg',
            ],
            [
                'name' => 'Jazz',
                'slug' => 'jazz',
                'description' => 'Konser dan festival jazz dengan penampilan dari musisi jazz ternama.',
                'image' => 'images/categories/jazz.jpg',
            ],
            [
                'name' => 'Electronic',
                'slug' => 'electronic',
                'description' => 'Festival dan konser musik elektronik dengan DJ dan produser music ternama.',
                'image' => 'images/categories/electronic.jpg',
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
        
        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
        
        $this->info('Data kategori berhasil ditambahkan!');
    }
    
    /**
     * Populate events
     */
    private function populateEvents()
    {
        $this->info('Menambahkan data konser...');
        
        // Get admin user or create one if it doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'admin@konserkuy.com'],
            [
                'name' => 'Admin KonserKUY',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        
        // Get all categories
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->error('Tidak ada kategori. Silakan tambahkan kategori terlebih dahulu.');
            return;
        }
        
        // Sample venues
        $venues = [
            'Istora Senayan, Jakarta',
            'Gelora Bung Karno, Jakarta',
            'ICE BSD, Tangerang',
            'JIExpo Kemayoran, Jakarta',
            'Lapangan D Senayan, Jakarta',
            'Tennis Indoor Senayan, Jakarta',
            'Telkomsel SICC, Bogor',
            'Bali International Convention Center',
            'Ciputra Artpreneur, Jakarta',
            'Graha Cakrawala, Malang',
        ];
        
        // Create 20 sample events
        for ($i = 1; $i <= 20; $i++) {
            $categoryModel = $categories->random();
            $category = $categoryModel->name;
            $title = $this->generateTitle($category);
            $date = Carbon::now()->addDays(rand(5, 180));
            $price = rand(10, 100) * 50000;
            
            $event = Event::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'description' => $this->generateDescription($category),
                    'category' => $category,
                    'date' => $date,
                    'location' => $venues[array_rand($venues)],
                    'poster_path' => 'images/events/placeholder.jpg',
                    'status' => 'active',
                    'ticket_price' => $price,
                    'ticket_quantity' => rand(100, 5000),
                    'user_id' => $user->id,
                ]
            );
            
            // Add tickets for this event
            $this->addTicketsForEvent($event);
        }
        
        $this->info('Data konser berhasil ditambahkan!');
    }
    
    /**
     * Add tickets for an event
     */
    private function addTicketsForEvent($event)
    {
        // Define ticket types
        $ticketTypes = ['Regular', 'Premium', 'VIP', 'VVIP'];
        
        // Define price multipliers
        $priceMultipliers = [1, 2, 4, 8];
        
        // Create tickets for each type
        for ($i = 0; $i < count($ticketTypes); $i++) {
            $ticket = Ticket::updateOrCreate(
                [
                    'event_id' => $event->id,
                    'ticket_type' => $ticketTypes[$i],
                ],
                [
                    'event_id' => $event->id,
                    'ticket_type' => $ticketTypes[$i],
                    'price' => $event->ticket_price * $priceMultipliers[$i],
                    'quota' => $event->ticket_quantity / count($ticketTypes),
                    'sold' => rand(0, $event->ticket_quantity / count($ticketTypes) / 2),
                    'ticket_code' => strtoupper(Str::random(8)),
                    'sale_start_date' => Carbon::now(),
                    'sale_end_date' => $event->date->copy()->subDays(1),
                ]
            );
        }
    }
    
    /**
     * Generate a random event title
     */
    private function generateTitle($category)
    {
        $prefix = '';
        
        switch ($category) {
            case 'K-Pop':
                $prefix = ['K-Pop Sensation', 'Korean Wave', 'K-Pop Festival', 'Hallyu Fest', 'K-Pop Showcase'];
                $artistNames = ['BTS', 'BLACKPINK', 'TWICE', 'EXO', 'SEVENTEEN', 'NCT', 'Red Velvet', 'STRAY KIDS', 'ENHYPEN', 'IVE', 'aespa'];
                break;
            case 'Pop':
                $prefix = ['Live Concert', 'Music Tour', 'Pop Show', 'Pop Sensation', 'World Tour'];
                $artistNames = ['Taylor Swift', 'Justin Bieber', 'Ariana Grande', 'Dua Lipa', 'Bruno Mars', 'Adele', 'Ed Sheeran', 'Rihanna', 'Coldplay', 'Olivia Rodrigo'];
                break;
            case 'Rock':
                $prefix = ['Rock Fest', 'Metal Fest', 'Rock Night', 'Live Loud', 'Rock Tour'];
                $artistNames = ['Metallica', 'Guns N\' Roses', 'Avenged Sevenfold', 'Green Day', 'Slipknot', 'Bring Me The Horizon', 'Muse', 'Red Hot Chili Peppers', 'Foo Fighters', 'Iron Maiden'];
                break;
            case 'Jazz':
                $prefix = ['Jazz Festival', 'Jazz Night', 'Smooth Jazz', 'Jazz & Blues', 'Jazz Show'];
                $artistNames = ['Kenny G', 'Norah Jones', 'Tulus', 'Jamie Cullum', 'Diana Krall', 'Gregory Porter', 'Kamasi Washington', 'Norah Jones', 'Michael Bublé', 'Java Jazz'];
                break;
            case 'Electronic':
                $prefix = ['EDM Festival', 'Rave Nation', 'Electro Night', 'DJ Fest', 'Dance Festival'];
                $artistNames = ['Martin Garrix', 'Calvin Harris', 'David Guetta', 'Marshmello', 'Djakarta Warehouse Project', 'Ultra Music Festival', 'Tomorrowland', 'EDC', 'Zedd', 'Tiësto'];
                break;
            case 'Indie':
                $prefix = ['Indie Fest', 'Alternative Show', 'Indie Night', 'Indie Live', 'Alternative Scene'];
                $artistNames = ['The 1975', 'Tame Impala', 'Arctic Monkeys', 'Twenty One Pilots', 'Cigarettes After Sex', 'Foals', 'The XX', 'The Neighbourhood', 'Mac DeMarco', 'The Strokes'];
                break;
            case 'Classical':
                $prefix = ['Symphony Night', 'Classical Concert', 'Orchestra Performance', 'Philharmonic', 'Chamber Music'];
                $artistNames = ['Vienna Philharmonic', 'Berlin Philharmonic', 'London Symphony Orchestra', 'Jakarta Symphony', 'Yo-Yo Ma', 'Lang Lang', 'Andrea Bocelli', 'Yiruma', 'Yanni', 'Beethoven'];
                break;
            case 'Festival':
                $prefix = ['Music Festival', 'International Festival', 'Summer Festival', 'All-Star Festival', 'Music Celebration'];
                $artistNames = ['Synchronize Fest', 'We The Fest', 'Soundrenaline', 'Coachella', 'Lollapalooza', 'Jakarta Fair', 'Java Soundsfair', 'Hammersonic', 'Jakarta International Java Jazz Festival', 'Djakarta Warehouse Project'];
                break;
            default:
                $prefix = ['Concert', 'Show', 'Live', 'Tour', 'Festival'];
                $artistNames = ['Various Artists', 'Multiple Performers', 'Star Line-up', 'Music Showcase', 'Grand Performance'];
        }
        
        $selectedPrefix = $prefix[array_rand($prefix)];
        $selectedArtist = $artistNames[array_rand($artistNames)];
        
        return $selectedArtist . ' - ' . $selectedPrefix . ' ' . Carbon::now()->addDays(rand(5, 180))->format('Y');
    }
    
    /**
     * Generate a random event description
     */
    private function generateDescription($category)
    {
        switch ($category) {
            case 'K-Pop':
                return 'Nikmati penampilan spesial dari artis-artis K-Pop ternama yang akan menampilkan hit terbesar mereka dalam konser yang spektakuler. Acara ini akan dipenuhi dengan koreografi memukau, lagu-lagu hits, dan interaksi spesial dengan penggemar.';
            case 'Pop':
                return 'Hadirilah konser musik pop yang akan menghadirkan penampilan memukau dari artis-artis papan atas dunia. Nikmati lagu-lagu hit dalam suasana konser yang meriah dengan tata panggung, pencahayaan, dan sistem suara kelas dunia.';
            case 'Rock':
                return 'Bersiaplah untuk menyaksikan pertunjukan rock yang energik dan menggetarkan jiwa. Konser ini akan menghadirkan band-band rock terbaik yang akan membawakan lagu-lagu legendaris mereka dengan penampilan panggung yang spektakuler.';
            case 'Jazz':
                return 'Nikmati malam yang tenang dengan alunan musik jazz dari musisi-musisi berbakat. Konser jazz ini menjanjikan pengalaman musik yang intim dan mengesankan dengan improvisasi dan personalisasi yang unik dari para musisi.';
            case 'Electronic':
                return 'Rasakanlah sensasi festival musik elektronik dengan DJ dan produser musik ternama. Acara ini akan dipenuhi dengan light show yang spektakuler, musik elektronik yang menghentak, dan suasana pesta yang tidak terlupakan.';
            case 'Indie':
                return 'Jelajahi suara musik indie yang unik dan autentik dari artis-artis berbakat. Konser ini menawarkan pengalaman musik yang lebih personal dan intim dengan sentuhan kreativitas yang khas dari setiap penampil.';
            case 'Classical':
                return 'Hadiri konser musik klasik yang elegan dengan orkestra ternama. Nikmati komposisi klasik dan kontemporer yang dibawakan dengan presisi dan keindahan yang memesona di venue dengan akustik terbaik.';
            case 'Festival':
                return 'Ikuti festival musik multi-hari yang menghadirkan puluhan artis dari berbagai genre musik. Acara ini menawarkan pengalaman festival lengkap dengan beberapa panggung, kuliner, seni, dan berbagai aktivitas menarik lainnya.';
            default:
                return 'Konser musik spesial yang menghadirkan penampilan terbaik dari artis-artis ternama. Jangan lewatkan kesempatan untuk menyaksikan pertunjukan memukau ini di venue kelas dunia dengan sistem suara dan pencahayaan terbaik.';
        }
    }
} 