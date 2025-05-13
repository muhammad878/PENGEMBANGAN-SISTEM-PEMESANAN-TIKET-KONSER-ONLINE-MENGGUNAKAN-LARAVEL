@extends('frontend.layouts.app')

@section('title', 'Tentang Kami - KonserKUY')

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
            <h1 class="text-4xl md:text-5xl font-bold mb-2 animate-fade-in-up">Tentang KonserKUY</h1>
            <p class="text-xl opacity-90 animate-fade-in-up">Platform ticketing konser #1 di Indonesia</p>
        </div>
    </div>

    <!-- About Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 hover-lift">
            <!-- Company Overview -->
            <div class="mb-14">
                <h2 class="text-3xl font-bold text-gradient mb-6">Siapa Kami</h2>
                <p class="text-slate-700 mb-5 text-lg leading-relaxed">
                    KonserKUY adalah platform ticketing konser terdepan di Indonesia yang didirikan pada tahun 2023. Kami berkomitmen untuk menyediakan pengalaman pembelian tiket konser yang mudah, aman, dan terpercaya bagi para penggemar musik dan event di seluruh Indonesia.
                </p>
                <p class="text-slate-700 mb-5 text-lg leading-relaxed">
                    Sebagai platform yang menghubungkan event organizer dengan penggemar musik, KonserKUY memastikan setiap transaksi tiket berlangsung dengan transparan dan aman. Kami telah menjadi mitra tepercaya bagi ratusan penyelenggara konser dan event musik di Indonesia.
                </p>
            </div>

            <!-- Our Mission -->
            <div class="mb-14">
                <h2 class="text-3xl font-bold text-gradient mb-6">Misi Kami</h2>
                <p class="text-slate-700 mb-5 text-lg leading-relaxed">
                    Misi kami adalah menjadi jembatan antara penyelenggara konser dan penggemar musik dengan menyediakan platform ticketing yang inovatif, mudah digunakan, dan aman. Kami berkomitmen untuk:
                </p>
                <ul class="list-none pl-0 text-slate-700 space-y-4 mb-6">
                    <li class="flex items-start">
                        <span class="bg-gradient-primary rounded-full p-1 mr-3 text-white flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span>Memastikan setiap tiket yang dijual adalah tiket asli dan sah</span>
                    </li>
                    <li class="flex items-start">
                        <span class="bg-gradient-primary rounded-full p-1 mr-3 text-white flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span>Menyediakan proses pembelian yang mudah dan cepat bagi para pelanggan</span>
                    </li>
                    <li class="flex items-start">
                        <span class="bg-gradient-primary rounded-full p-1 mr-3 text-white flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span>Memberikan tools dan solusi terbaik bagi penyelenggara konser untuk memasarkan event mereka</span>
                    </li>
                    <li class="flex items-start">
                        <span class="bg-gradient-primary rounded-full p-1 mr-3 text-white flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span>Mendukung pertumbuhan industri musik live di Indonesia</span>
                    </li>
                    <li class="flex items-start">
                        <span class="bg-gradient-primary rounded-full p-1 mr-3 text-white flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span>Menciptakan pengalaman belanja tiket online yang aman dan nyaman</span>
                    </li>
                </ul>
            </div>

            <!-- Why Choose Us -->
            <div class="mb-14">
                <h2 class="text-3xl font-bold text-gradient mb-8">Mengapa Memilih KonserKUY</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6 bg-slate-50 rounded-xl hover-lift transition duration-300 border border-slate-100">
                        <div class="w-14 h-14 bg-gradient-primary rounded-full flex items-center justify-center mb-5 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h8V3a1 1 0 112 0v1h1a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 011-1zm2 3v1a1 1 0 11-2 0V5H3v4h14V5h-2v1a1 1 0 11-2 0V5H7zm-2 8v2h2v-2H5zm0-4v2h2V9H5zm6 4v2h2v-2h-2zm0-4v2h2V9h-2zm-3 0v2h2V9H8zm0 4v2h2v-2H8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800 text-xl mb-3">Jaminan Tiket Asli</h3>
                        <p class="text-slate-600">Semua tiket yang dijual di platform KonserKUY dijamin keasliannya dan langsung dari penyelenggara resmi.</p>
                    </div>
                    
                    <div class="p-6 bg-slate-50 rounded-xl hover-lift transition duration-300 border border-slate-100">
                        <div class="w-14 h-14 bg-gradient-primary rounded-full flex items-center justify-center mb-5 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800 text-xl mb-3">Transaksi Aman</h3>
                        <p class="text-slate-600">Kami mengutamakan keamanan dalam setiap transaksi dengan sistem pembayaran yang terintegrasi dan terpercaya.</p>
                    </div>
                    
                    <div class="p-6 bg-slate-50 rounded-xl hover-lift transition duration-300 border border-slate-100">
                        <div class="w-14 h-14 bg-gradient-primary rounded-full flex items-center justify-center mb-5 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800 text-xl mb-3">Layanan Pelanggan</h3>
                        <p class="text-slate-600">Tim dukungan pelanggan kami siap membantu Anda dengan pertanyaan atau masalah yang mungkin timbul.</p>
                    </div>
                </div>
            </div>

            <!-- Team Section -->
            <div>
                <h2 class="text-3xl font-bold text-gradient mb-8">Tim Kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center hover-lift transition duration-300">
                        <div class="w-36 h-36 rounded-full bg-gradient-primary mx-auto mb-5 relative overflow-hidden shadow-xl">
                            <!-- Placeholder for actual photo -->
                            <div class="absolute inset-0 flex items-center justify-center text-white text-4xl font-bold">JD</div>
                        </div>
                        <h3 class="font-bold text-slate-800 text-xl mb-1">John Doe</h3>
                        <p class="text-slate-500">Chief Executive Officer</p>
                    </div>
                    
                    <div class="text-center hover-lift transition duration-300">
                        <div class="w-36 h-36 rounded-full bg-gradient-primary mx-auto mb-5 relative overflow-hidden shadow-xl">
                            <!-- Placeholder for actual photo -->
                            <div class="absolute inset-0 flex items-center justify-center text-white text-4xl font-bold">JS</div>
                        </div>
                        <h3 class="font-bold text-slate-800 text-xl mb-1">Jane Smith</h3>
                        <p class="text-slate-500">Chief Technology Officer</p>
                    </div>
                    
                    <div class="text-center hover-lift transition duration-300">
                        <div class="w-36 h-36 rounded-full bg-gradient-primary mx-auto mb-5 relative overflow-hidden shadow-xl">
                            <!-- Placeholder for actual photo -->
                            <div class="absolute inset-0 flex items-center justify-center text-white text-4xl font-bold">RJ</div>
                        </div>
                        <h3 class="font-bold text-slate-800 text-xl mb-1">Robert Johnson</h3>
                        <p class="text-slate-500">Chief Marketing Officer</p>
                    </div>
                </div>
            </div>
            
            <!-- Stats Section -->
            <div class="mt-16 bg-slate-50 p-8 rounded-2xl border border-slate-100">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                    <div class="p-4">
                        <div class="text-4xl font-bold text-gradient mb-2">500+</div>
                        <p class="text-slate-600">Konser Diselenggarakan</p>
                    </div>
                    <div class="p-4">
                        <div class="text-4xl font-bold text-gradient mb-2">50,000+</div>
                        <p class="text-slate-600">Pelanggan Puas</p>
                    </div>
                    <div class="p-4">
                        <div class="text-4xl font-bold text-gradient mb-2">100+</div>
                        <p class="text-slate-600">Event Organizer Partner</p>
                    </div>
                    <div class="p-4">
                        <div class="text-4xl font-bold text-gradient mb-2">30+</div>
                        <p class="text-slate-600">Kota di Indonesia</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 