<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan kategori sudah dibuat
        $categories = Category::all()->keyBy('slug')->toArray();
        
        // Organizer ID (asumsikan ID 2 adalah pengguna Event Organizer dari DatabaseSeeder)
        $organizerId = 2;

        $events = [
            [
                'title' => 'Blackpink World Tour 2023: Born Pink in Jakarta',
                'description' => 'Experience the global phenomenon BLACKPINK live in Jakarta for their "Born Pink" world tour! This high-energy concert will feature their biggest hits including "Pink Venom," "DDU-DU DDU-DU," "How You Like That," and many more. With stunning choreography, impressive stage setups, and their signature charisma, BLACKPINK promises an unforgettable night for all BLINKs!',
                'category' => 'K-Pop',
                'date' => Carbon::now()->addDays(30)->setHour(19)->setMinute(30),
                'location' => 'Gelora Bung Karno Stadium, Jakarta',
                'status' => 'active',
                'ticket_price' => 1500000, // Harga dasar, tiket akan bervariasi
                'ticket_quantity' => 50000,
                'poster_path' => 'images/events/blackpink.jpg',
            ],
            [
                'title' => 'Coldplay: Music of the Spheres World Tour',
                'description' => 'Coldplay brings their spectacular "Music of the Spheres" world tour to Indonesia for the first time! Experience Chris Martin and the band perform their greatest hits along with tracks from their latest album in an environmentally conscious show featuring incredible visuals, light shows, and interactive elements.',
                'category' => 'Pop',
                'date' => Carbon::now()->addDays(45)->setHour(20)->setMinute(0),
                'location' => 'Gelora Bung Karno Stadium, Jakarta',
                'status' => 'active',
                'ticket_price' => 1800000, // Harga dasar, tiket akan bervariasi
                'ticket_quantity' => 40000,
                'poster_path' => 'images/events/coldplay.jpg',
            ],
            [
                'title' => 'Ed Sheeran: Mathematics Tour',
                'description' => 'Join the Grammy-winning singer-songwriter Ed Sheeran as he brings his "Mathematics Tour" to Jakarta. Experience his chart-topping hits like "Shape of You," "Perfect," and "Bad Habits" in an intimate solo performance featuring his signature loop pedal and acoustic guitar.',
                'category' => 'Pop',
                'date' => Carbon::now()->addDays(60)->setHour(19)->setMinute(0),
                'location' => 'Indonesia Convention Exhibition (ICE), BSD City',
                'status' => 'active',
                'ticket_price' => 1350000, // Harga dasar, tiket akan bervariasi
                'ticket_quantity' => 25000,
                'poster_path' => 'images/events/edsheeran.jpg',
            ],
            [
                'title' => 'BTS Reunion Special: Map of the Soul',
                'description' => 'The moment all ARMY has been waiting for! Experience the emotional reunion of all seven BTS members after their military service for this exclusive world tour. Witness RM, Jin, Suga, J-Hope, Jimin, V, and Jungkook perform their biggest hits together on stage once again!',
                'category' => 'K-Pop',
                'date' => Carbon::now()->addDays(90)->setHour(18)->setMinute(30),
                'location' => 'Gelora Bung Karno Stadium, Jakarta',
                'status' => 'active',
                'ticket_price' => 2000000, // Harga dasar, tiket akan bervariasi
                'ticket_quantity' => 60000,
                'poster_path' => 'images/events/bts.jpg',
            ],
            [
                'title' => 'Tame Impala: Slow Rush Tour',
                'description' => 'Australian psychedelic music project Tame Impala (Kevin Parker) brings their mesmerizing "Slow Rush Tour" to Indonesia for the first time. Experience their hypnotic sounds, mind-bending visuals, and dreamy atmosphere in this immersive concert experience.',
                'category' => 'Indie',
                'date' => Carbon::now()->addDays(55)->setHour(20)->setMinute(0),
                'location' => 'Beach City International Stadium, Ancol',
                'status' => 'active',
                'ticket_price' => 1250000, // Harga dasar, tiket akan bervariasi
                'ticket_quantity' => 15000,
                'poster_path' => 'images/events/tameimpala.jpg',
            ],
            [
                'title' => 'Java Jazz Festival 2023',
                'description' => 'Indonesia\'s premiere jazz event returns with an incredible lineup of international and local jazz artists. Experience three days of smooth sounds, improvisation, and musical excellence across multiple stages in this world-renowned festival.',
                'category' => 'Jazz',
                'date' => Carbon::now()->addDays(75)->setHour(16)->setMinute(0),
                'location' => 'JIExpo Kemayoran, Jakarta',
                'status' => 'active',
                'ticket_price' => 1500000, // Harga dasar, tiket akan bervariasi
                'ticket_quantity' => 30000,
                'poster_path' => 'images/events/javajazz.jpg',
            ],
            [
                'title' => 'Justin Bieber: Justice World Tour',
                'description' => 'Global pop sensation Justin Bieber brings his "Justice World Tour" to Indonesia! Beliebers can look forward to an energetic performance featuring his greatest hits and newest tracks in a state-of-the-art production with spectacular choreography and visuals.',
                'category' => 'Pop',
                'date' => Carbon::now()->addDays(100)->setHour(19)->setMinute(30),
                'location' => 'Madya Stadium, GBK Sports Complex, Jakarta',
                'status' => 'active',
                'ticket_price' => 1650000, // Harga dasar, tiket akan bervariasi
                'ticket_quantity' => 25000,
                'poster_path' => 'images/events/justinbieber.jpg',
            ],
            [
                'title' => 'Djakarta Warehouse Project 2023',
                'description' => 'Asia\'s largest dance music festival returns! Experience world-class DJs and electronic music producers across multiple stages in this two-day festival featuring incredible production, immersive art installations, and unforgettable dance music.',
                'category' => 'Electronic',
                'date' => Carbon::now()->addDays(85)->setHour(18)->setMinute(0),
                'location' => 'JIExpo Kemayoran, Jakarta',
                'status' => 'active',
                'ticket_price' => 1400000, // Harga dasar, tiket akan bervariasi
                'ticket_quantity' => 45000,
                'poster_path' => 'images/events/dwp.jpg',
            ],
            [
                'title' => 'Adele: Live in Jakarta',
                'description' => 'Grammy-winning superstar Adele makes her Indonesian debut in this intimate concert showcasing her powerful vocals and emotionally charged performances. Experience her timeless ballads and new material in a sophisticated production designed to highlight her remarkable voice.',
                'category' => 'Pop',
                'date' => Carbon::now()->addDays(110)->setHour(20)->setMinute(0),
                'location' => 'Sentul International Convention Center, Bogor',
                'status' => 'active',
                'ticket_price' => 1750000, // Harga dasar, tiket akan bervariasi
                'ticket_quantity' => 20000,
                'poster_path' => 'images/events/adele.jpg',
            ],
            [
                'title' => 'Metallica: 72 Seasons World Tour',
                'description' => 'Legendary metal band Metallica returns to Indonesia as part of their world tour supporting their latest album. Prepare for an evening of thrashing guitars, thunderous drums, and classic metal anthems from their 40+ year career.',
                'category' => 'Rock',
                'date' => Carbon::now()->addDays(65)->setHour(19)->setMinute(0),
                'location' => 'Gelora Bung Karno Stadium, Jakarta',
                'status' => 'active',
                'ticket_price' => 1350000, // Harga dasar, tiket akan bervariasi
                'ticket_quantity' => 35000,
                'poster_path' => 'images/events/metallica.jpg',
            ],
            [
                'title' => 'Red Velvet: Free Ride Tour',
                'description' => 'K-pop girl group sensation Red Velvet brings their "Free Ride" tour to Indonesia! Experience their unique blend of vivid concepts, powerful choreography, and catchy songs in this high-energy performance featuring stunning visuals and special effects.',
                'category' => 'K-Pop',
                'date' => Carbon::now()->addDays(40)->setHour(19)->setMinute(0),
                'location' => 'Tennis Indoor Stadium, Senayan, Jakarta',
                'status' => 'active',
                'ticket_price' => 1300000, // Harga dasar, tiket akan bervariasi
                'ticket_quantity' => 12000,
                'poster_path' => 'images/events/redvelvet.jpg',
            ],
            [
                'title' => 'Jakarta International Classical Music Festival',
                'description' => 'Celebrate the timeless beauty of classical music in this prestigious annual festival featuring renowned orchestras, conductors, and soloists from around the world performing in one of Jakarta\'s most acoustically perfect venues.',
                'category' => 'Classical',
                'date' => Carbon::now()->addDays(70)->setHour(19)->setMinute(30),
                'location' => 'Aula Simfonia Jakarta',
                'status' => 'active',
                'ticket_price' => 1000000, // Harga dasar, tiket akan bervariasi
                'ticket_quantity' => 5000,
                'poster_path' => 'images/events/classical.jpg',
            ],
            // Tambahan event Rock
            [
                'title' => 'Foo Fighters: Everything or Nothing at All Tour',
                'description' => 'Rock legends Foo Fighters bring their high-energy show to Jakarta, featuring Dave Grohl and the band performing classics and new material from their latest album. Experience one of rock\'s most electrifying live acts in this special arena performance.',
                'category' => 'Rock',
                'date' => Carbon::now()->addDays(50)->setHour(20)->setMinute(0),
                'location' => 'Istora Senayan, Jakarta',
                'status' => 'active',
                'ticket_price' => 1400000,
                'ticket_quantity' => 20000,
                'poster_path' => 'images/events/foofighters.jpg',
            ],
            // Tambahan event Jazz
            [
                'title' => 'Norah Jones: Come Away With Me Anniversary Tour',
                'description' => 'Grammy-winning jazz and pop artist Norah Jones celebrates the anniversary of her iconic album with a special intimate concert featuring her sultry vocals, piano prowess, and a setlist of beloved classics and new material.',
                'category' => 'Jazz',
                'date' => Carbon::now()->addDays(45)->setHour(19)->setMinute(30),
                'location' => 'Balai Sarbini, Jakarta',
                'status' => 'active',
                'ticket_price' => 1200000,
                'ticket_quantity' => 8000,
                'poster_path' => 'images/events/norahjones.jpg',
            ],
            // Tambahan event Electronic
            [
                'title' => 'Deadmau5: Cube V3 World Tour',
                'description' => 'Electronic music pioneer Deadmau5 brings his groundbreaking Cube V3 production to Jakarta. Experience cutting-edge visuals, immersive lighting, and pulsating electronic music in this technological marvel of a show.',
                'category' => 'Electronic',
                'date' => Carbon::now()->addDays(60)->setHour(21)->setMinute(0),
                'location' => 'Eco Park Ancol, Jakarta',
                'status' => 'active',
                'ticket_price' => 1350000,
                'ticket_quantity' => 15000,
                'poster_path' => 'images/events/deadmau5.jpg',
            ],
            // Tambahan event Indie
            [
                'title' => 'The Strokes: The New Abnormal Tour',
                'description' => 'Indie rock icons The Strokes come to Jakarta for the first time, bringing their influential sound and catalog of hits from their twenty-plus year career, including material from their critically acclaimed album "The New Abnormal."',
                'category' => 'Indie',
                'date' => Carbon::now()->addDays(80)->setHour(20)->setMinute(0),
                'location' => 'Tennis Indoor Senayan, Jakarta',
                'status' => 'active',
                'ticket_price' => 1250000,
                'ticket_quantity' => 10000,
                'poster_path' => 'images/events/thestrokes.jpg',
            ],
            // Tambahan event Classical
            [
                'title' => 'Yo-Yo Ma: Bach Cello Suites',
                'description' => 'World-renowned cellist Yo-Yo Ma presents Bach\'s complete cello suites in one unforgettable evening. Experience the mastery of this living legend as he performs some of the most profound works ever written for solo cello.',
                'category' => 'Classical',
                'date' => Carbon::now()->addDays(90)->setHour(19)->setMinute(0),
                'location' => 'Aula Simfonia Jakarta',
                'status' => 'active',
                'ticket_price' => 1500000,
                'ticket_quantity' => 4000,
                'poster_path' => 'images/events/yoyoma.jpg',
            ],
            // Tambahan event K-Pop
            [
                'title' => 'TWICE: Ready To Be World Tour',
                'description' => 'Global K-pop sensation TWICE brings their "Ready To Be" world tour to Jakarta. Experience the charm and talent of this beloved girl group as they perform their biggest hits with spectacular choreography and production.',
                'category' => 'K-Pop',
                'date' => Carbon::now()->addDays(70)->setHour(19)->setMinute(0),
                'location' => 'Indonesia Convention Exhibition (ICE), BSD City',
                'status' => 'active',
                'ticket_price' => 1450000,
                'ticket_quantity' => 25000,
                'poster_path' => 'images/events/twice.jpg',
            ],
            // Tambahan event Rock
            [
                'title' => 'Guns N\' Roses: Not In This Lifetime Tour',
                'description' => 'Rock and Roll Hall of Famers Guns N\' Roses reunite for their spectacular world tour. Experience Axl, Slash, and Duff perform their catalog of rock anthems in this must-see concert event.',
                'category' => 'Rock',
                'date' => Carbon::now()->addDays(85)->setHour(20)->setMinute(0),
                'location' => 'Gelora Bung Karno Stadium, Jakarta',
                'status' => 'active',
                'ticket_price' => 1500000,
                'ticket_quantity' => 40000,
                'poster_path' => 'images/events/gunsnroses.jpg',
            ],
        ];

        foreach ($events as $eventData) {
            // Dapatkan slug kategori yang benar
            $categoryName = $eventData['category'];
            $categorySlug = array_key_exists($categoryName, $categories) ? Str::slug($categoryName) : Str::slug($categoryName);
            
            // Get category ID
            $categoryId = null;
            foreach ($categories as $slug => $category) {
                if (strtolower($slug) === strtolower(Str::slug($categoryName))) {
                    $categoryId = $category['id'];
                    break;
                }
            }
            
            Event::create([
                'user_id' => $organizerId,
                'title' => $eventData['title'],
                'slug' => Str::slug($eventData['title']),
                'description' => $eventData['description'],
                'category' => $categorySlug,
                'category_id' => $categoryId,
                'date' => $eventData['date'],
                'location' => $eventData['location'],
                'status' => $eventData['status'],
                'ticket_price' => $eventData['ticket_price'],
                'ticket_quantity' => $eventData['ticket_quantity'],
                'poster_path' => $eventData['poster_path'],
            ]);
        }
    }
} 