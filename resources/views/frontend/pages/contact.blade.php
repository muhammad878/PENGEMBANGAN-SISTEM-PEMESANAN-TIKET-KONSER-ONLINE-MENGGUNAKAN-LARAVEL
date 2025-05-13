@extends('frontend.layouts.app')

@section('title', 'Hubungi Kami - KonserKUY')

@section('content')
<div class="bg-slate-50">
    <!-- Page Header -->
    <div class="bg-gradient-primary text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute animate-float" style="top: 10%; left: 5%;">
                <svg class="w-20 h-20 text-white opacity-20" viewBox="0 0 80 80" fill="currentColor">
                    <circle cx="40" cy="40" r="40" />
                </svg>
            </div>
            <div class="absolute animate-float animation-delay-500" style="top: 20%; right: 10%;">
                <svg class="w-32 h-32 text-white opacity-10" viewBox="0 0 80 80" fill="currentColor">
                    <circle cx="40" cy="40" r="40" />
                </svg>
            </div>
            <div class="absolute bottom-0 left-0 right-0">
                <svg class="w-full text-slate-50" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="currentColor" opacity=".25"></path>
                    <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" fill="currentColor" opacity=".5"></path>
                </svg>
            </div>
        </div>
        <div class="container mx-auto px-4 py-16 relative">
            <h1 class="text-4xl md:text-5xl font-bold mb-2 animate-fade-in-up">Hubungi Kami</h1>
            <p class="text-xl opacity-90 animate-fade-in-up">Kami siap membantu Anda</p>
        </div>
    </div>

    <!-- Contact Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid md:grid-cols-2 gap-10">
            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 hover-lift">
                <h2 class="text-3xl font-bold text-gradient mb-6">Kirim Pesan</h2>
                
                <form method="POST" action="{{ route('contact.send') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition-colors" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Alamat Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition-colors" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Subject Field -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-slate-700 mb-2">Subjek</label>
                        <input type="text" id="subject" name="subject" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition-colors" required>
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Message Field -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-slate-700 mb-2">Pesan</label>
                        <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition-colors" required></textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full btn-gradient text-white font-medium py-3 px-6 rounded-lg transition-transform flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                            </svg>
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Contact Information -->
            <div class="space-y-10">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 hover-lift">
                    <h2 class="text-3xl font-bold text-gradient mb-8">Informasi Kontak</h2>
                    
                    <div class="space-y-6">
                        <!-- Address -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 bg-gradient-primary rounded-full flex items-center justify-center text-white shadow-lg">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-slate-800">Alamat</h3>
                                <p class="mt-2 text-slate-600 leading-relaxed">
                                    Jl. Musik Raya No. 88<br>
                                    Jakarta Selatan, DKI Jakarta<br>
                                    Indonesia 12345
                                </p>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 bg-gradient-primary rounded-full flex items-center justify-center text-white shadow-lg">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-slate-800">Email</h3>
                                <p class="mt-2 text-slate-600 leading-relaxed">
                                    Bantuan Pelanggan: <a href="mailto:help@konserkuy.com" class="text-primary-600 hover:text-primary-700 transition-colors">help@konserkuy.com</a><br>
                                    Info Bisnis: <a href="mailto:info@konserkuy.com" class="text-primary-600 hover:text-primary-700 transition-colors">info@konserkuy.com</a>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Phone -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 bg-gradient-primary rounded-full flex items-center justify-center text-white shadow-lg">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-slate-800">Telepon</h3>
                                <p class="mt-2 text-slate-600 leading-relaxed">
                                    Bantuan Pelanggan: <a href="tel:+6281234567890" class="text-primary-600 hover:text-primary-700 transition-colors">+62 812-3456-7890</a><br>
                                    Kantor: <a href="tel:+6281234567899" class="text-primary-600 hover:text-primary-700 transition-colors">+62 812-3456-7899</a>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Working Hours -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 bg-gradient-primary rounded-full flex items-center justify-center text-white shadow-lg">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-slate-800">Jam Operasional</h3>
                                <p class="mt-2 text-slate-600 leading-relaxed">
                                    Senin - Jumat: 08:00 - 17:00<br>
                                    Sabtu: 09:00 - 15:00<br>
                                    Minggu: Tutup
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 hover-lift">
                    <h2 class="text-3xl font-bold text-gradient mb-8">Ikuti Kami</h2>
                    
                    <div class="flex space-x-6 items-center justify-center">
                        <a href="#" class="group">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-slate-100 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300 shadow-sm">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </a>
                        
                        <a href="#" class="group">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-slate-100 group-hover:bg-pink-500 group-hover:text-white transition-all duration-300 shadow-sm">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.01 3.808.06 1.064.05 1.79.218 2.427.465.66.254 1.216.598 1.772 1.153.509.5.902 1.105 1.153 1.772.247.637.415 1.363.465 2.427.047 1.024.06 1.379.06 3.808s-.013 2.784-.06 3.808c-.05 1.064-.218 1.79-.465 2.427a4.902 4.902 0 01-1.153 1.772c-.5.509-1.105.902-1.772 1.153-.637.247-1.363.415-2.427.465-1.024.047-1.379.06-3.808.06s-2.784-.013-3.808-.06c-1.064-.05-1.79-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.637-.415-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808s.013-2.784.06-3.808c.05-1.064.218-1.79.465-2.427.254-.66.598-1.216 1.153-1.772.5-.509 1.105-.902 1.772-1.153.637-.247 1.363-.415 2.427-.465 1.024-.047 1.379-.06 3.808-.06M12 0C8.741 0 8.332.014 7.052.072 5.197.157 3.355.673 2.014 2.014.673 3.355.157 5.197.072 7.052.014 8.332 0 8.741 0 12c0 3.259.014 3.668.072 4.948.085 1.855.603 3.697 1.942 5.038 1.345 1.345 3.187 1.857 5.038 1.942 1.281.058 1.69.072 4.948.072 3.259 0 3.668-.014 4.948-.072 1.855-.085 3.697-.603 5.038-1.942 1.345-1.345 1.857-3.187 1.942-5.038.058-1.281.072-1.69.072-4.948 0-3.259-.014-3.668-.072-4.948-.085-1.855-.603-3.697-1.942-5.038C20.643.671 18.801.156 16.948.072 15.668.014 15.259 0 12 0z" clip-rule="evenodd" />
                                    <path d="M12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8z" />
                                    <circle cx="18.406" cy="5.594" r="1.44" />
                                </svg>
                            </div>
                        </a>
                        
                        <a href="#" class="group">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-slate-100 group-hover:bg-blue-400 group-hover:text-white transition-all duration-300 shadow-sm">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </div>
                        </a>
                        
                        <a href="#" class="group">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-slate-100 group-hover:bg-red-500 group-hover:text-white transition-all duration-300 shadow-sm">
                                <span class="sr-only">YouTube</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gradient mb-6">Lokasi Kami</h2>
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden h-96 hover-lift">
                <!-- Replace with actual Google Maps or other map embed -->
                <div class="w-full h-full flex items-center justify-center bg-slate-100">
                    <p class="text-slate-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        Peta Lokasi KonserKUY
                    </p>
                    <!-- Uncomment and replace with your actual Google Maps API Key -->
                    <!-- <iframe 
                        width="100%" 
                        height="100%" 
                        frameborder="0" 
                        style="border:0" 
                        src="https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q=Space+Needle,Seattle+WA" 
                        allowfullscreen>
                    </iframe> -->
                </div>
            </div>
        </div>
        
        <!-- FAQ Section -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gradient mb-8">Pertanyaan Umum</h2>
            
            <div class="space-y-5">
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover-lift transition-all duration-300">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-white focus:outline-none">
                        <span class="font-bold text-slate-800 text-lg">Bagaimana cara membeli tiket di KonserKUY?</span>
                        <div class="w-8 h-8 bg-gradient-primary rounded-full flex items-center justify-center text-white">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="px-6 pb-4">
                        <p class="text-slate-600">
                            Untuk membeli tiket, Anda perlu mendaftar atau masuk ke akun KonserKUY Anda. Pilih acara yang ingin Anda hadiri, pilih kategori tiket, dan lanjutkan ke proses pembayaran. Setelah pembayaran berhasil, e-ticket akan dikirimkan ke email Anda.
                        </p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover-lift transition-all duration-300">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-white focus:outline-none">
                        <span class="font-bold text-slate-800 text-lg">Apakah saya bisa mendapatkan pengembalian dana (refund)?</span>
                        <div class="w-8 h-8 bg-gradient-primary rounded-full flex items-center justify-center text-white">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="px-6 pb-4">
                        <p class="text-slate-600">
                            Kebijakan pengembalian dana bervariasi tergantung pada acara dan penyelenggara. Secara umum, tiket yang sudah dibeli tidak dapat dikembalikan kecuali jika acara dibatalkan oleh penyelenggara. Untuk informasi lebih lanjut, silakan lihat ketentuan dan syarat pembelian tiket untuk acara tertentu.
                        </p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover-lift transition-all duration-300">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-white focus:outline-none">
                        <span class="font-bold text-slate-800 text-lg">Bagaimana cara menjadi penyelenggara acara di KonserKUY?</span>
                        <div class="w-8 h-8 bg-gradient-primary rounded-full flex items-center justify-center text-white">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="px-6 pb-4">
                        <p class="text-slate-600">
                            Untuk menjadi penyelenggara acara di KonserKUY, Anda perlu mendaftar sebagai Event Organizer (EO). Setelah mendaftar, akun Anda akan diverifikasi oleh tim kami. Setelah disetujui, Anda dapat mulai membuat dan mempublikasikan acara Anda di platform kami.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 