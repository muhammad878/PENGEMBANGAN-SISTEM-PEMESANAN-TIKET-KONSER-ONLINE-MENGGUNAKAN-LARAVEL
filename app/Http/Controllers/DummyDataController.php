<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DummyDataController extends Controller
{
    public function createDummyEvent()
    {
        try {
            // Cari atau buat kategori Festival
            $category = Category::firstOrCreate(
                ['slug' => 'festival'],
                [
                    'name' => 'Festival',
                    'slug' => 'festival',
                    'description' => 'Kategori konser Festival'
                ]
            );

            // Buat slug yang unik untuk event baru
            $title = 'Festival Pantai Clumik';
            $baseSlug = 'festival-pantai-clumik';
            $timestamp = time();
            $slug = $baseSlug . '-' . $timestamp; // Tambahkan timestamp agar selalu unik
            
            // Pastikan slug tidak duplikat
            while (Event::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $timestamp . '-' . rand(1, 100);
            }

            // Buat event dummy dengan maps dan lokasi
            $event = new Event();
            $event->title = $title;
            $event->slug = $slug;
            $event->description = 'Festival musik di Pantai Clumik dengan berbagai musisi lokal dan nasional. Nikmati keindahan pantai sambil menikmati musik yang menghibur.';
            $event->location = 'Pantai Clumik, Jepara';
            $event->maps_link = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31706.628159762207!2d110.66124916076657!3d-6.606036850500686!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e711fd9c0ba7a95%3A0xe4965f059a3a2056!2sPantai%20Clumik!5e0!3m2!1sid!2sid!4v1747062037236!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
            $event->date = now()->addDays(30);
            $event->category = 'Festival';
            $event->category_id = $category->id;
            $event->ticket_price = 150000;
            $event->ticket_quantity = 500;
            $event->user_id = 1; // Pastikan user ID 1 ada di database
            $event->status = 'active';
            
            // Gunakan default venue image
            $venueImagePath = "uploads/venue-images/venue-{$timestamp}.jpg";
            $fullVenueImagePath = public_path($venueImagePath);
            
            // Pastikan direktori ada untuk venue images
            if (!file_exists(public_path('uploads/venue-images'))) {
                mkdir(public_path('uploads/venue-images'), 0777, true);
            }
            
            // Copy dari images jika ada
            if (file_exists(public_path('images/default-event.jpg'))) {
                copy(public_path('images/default-event.jpg'), $fullVenueImagePath);
                $event->venue_image_path = $venueImagePath;
            }
            
            // Tambahkan poster untuk event
            // Pastikan direktori poster ada
            $postersDir = public_path('uploads/event-posters');
            if (!file_exists($postersDir)) {
                mkdir($postersDir, 0777, true);
            }
            
            // Gunakan default poster atau buat poster baru
            $posterPath = 'uploads/event-posters/event-' . time() . '.jpg';
            $fullPosterPath = public_path($posterPath);
            
            // Copy dari images jika ada
            if (file_exists(public_path('images/default-event.jpg'))) {
                copy(public_path('images/default-event.jpg'), $fullPosterPath);
                $event->poster_path = $posterPath;
            }
            
            $event->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Event dummy dengan maps dan lokasi berhasil dibuat',
                'event' => $event
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating dummy event: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat event dummy: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
