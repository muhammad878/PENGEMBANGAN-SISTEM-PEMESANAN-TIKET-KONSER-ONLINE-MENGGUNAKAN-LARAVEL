<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedConcertData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'konser:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Isi database dengan data konser dan tiket';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses pengisian data konser...');
        
        // Jalankan seeder tertentu saja
        $this->info('Membuat direktori gambar...');
        Artisan::call('db:seed', ['--class' => 'ImageDirectoriesSeeder']);
        $this->info(Artisan::output());
        
        $this->info('Mengisi data kategori...');
        Artisan::call('db:seed', ['--class' => 'CategorySeeder']);
        $this->info(Artisan::output());
        
        $this->info('Mengisi data konser...');
        Artisan::call('db:seed', ['--class' => 'EventSeeder']);
        $this->info(Artisan::output());
        
        $this->info('Mengisi data tiket...');
        Artisan::call('db:seed', ['--class' => 'TicketSeeder']);
        $this->info(Artisan::output());
        
        $this->info('Pengisian data konser berhasil diselesaikan!');
        $this->info('Untuk melihat data konser, jalankan: php artisan konser:view');
        $this->info('Untuk melihat data kategori, jalankan: php artisan konser:view --categories');
        
        return 0;
    }
} 