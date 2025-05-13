@extends('frontend.layouts.app')

@section('title', 'FAQ - KonserKUY')

@section('content')
<div class="bg-gray-50">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-pink-600 to-purple-600 text-white">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Pertanyaan yang Sering Diajukan</h1>
            <p class="text-lg opacity-90">Temukan jawaban atas pertanyaan umum tentang KonserKUY</p>
        </div>
    </div>

    <!-- FAQ Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
            <!-- Search -->
            <div class="mb-10">
                <form action="#" method="get" class="flex">
                    <input type="text" placeholder="Cari pertanyaan..." class="w-full px-4 py-3 rounded-l-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                    <button type="submit" class="bg-pink-600 text-white px-4 py-3 rounded-r-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Categories -->
            <div class="mb-10">
                <div class="flex flex-wrap gap-2">
                    <button class="px-4 py-2 bg-pink-600 text-white rounded-full text-sm font-medium hover:bg-pink-700 transition">Semua</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full text-sm font-medium hover:bg-gray-300 transition">Akun</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full text-sm font-medium hover:bg-gray-300 transition">Pembelian Tiket</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full text-sm font-medium hover:bg-gray-300 transition">Pembayaran</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full text-sm font-medium hover:bg-gray-300 transition">E-Ticket</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full text-sm font-medium hover:bg-gray-300 transition">Pengembalian Dana</button>
                </div>
            </div>

            <!-- FAQ Items -->
            <div class="space-y-6" x-data="{active: 0}">
                <!-- General Questions -->
                <h2 class="text-xl font-bold text-gray-800 mb-4">Umum</h2>

                <!-- Item 1 -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 text-left" @click="active === 1 ? active = 0 : active = 1">
                        <span class="font-medium text-gray-800">Apa itu KonserKUY?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{'transform rotate-180': active === 1}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="active === 1" class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            KonserKUY adalah platform ticketing konser terdepan di Indonesia yang menyediakan tiket konser dari berbagai promotor dan penyelenggara event. Kami berkomitmen untuk menyediakan pengalaman pembelian tiket yang mudah, aman, dan terpercaya bagi para penggemar musik di Indonesia.
                        </p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 text-left" @click="active === 2 ? active = 0 : active = 2">
                        <span class="font-medium text-gray-800">Bagaimana cara mendaftar di KonserKUY?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{'transform rotate-180': active === 2}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="active === 2" class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            Untuk mendaftar di KonserKUY, klik tombol "Daftar" di pojok kanan atas halaman. Isi formulir pendaftaran dengan data diri Anda seperti nama, email, dan password. Setelah itu, verifikasi email Anda dengan mengklik tautan yang kami kirimkan. Sekarang Anda sudah dapat login dan membeli tiket konser favorit Anda.
                        </p>
                    </div>
                </div>

                <!-- Ticket Purchase -->
                <h2 class="text-xl font-bold text-gray-800 mb-4 mt-8">Pembelian Tiket</h2>

                <!-- Item 3 -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 text-left" @click="active === 3 ? active = 0 : active = 3">
                        <span class="font-medium text-gray-800">Bagaimana cara membeli tiket di KonserKUY?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{'transform rotate-180': active === 3}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="active === 3" class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            Untuk membeli tiket, pilih konser yang ingin Anda kunjungi dari halaman utama atau melalui halaman Konser. Pada halaman detail konser, pilih jenis tiket yang Anda inginkan, masukkan jumlah tiket, lalu klik "Beli". Anda akan diarahkan ke halaman pembayaran untuk menyelesaikan transaksi.
                        </p>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 text-left" @click="active === 4 ? active = 0 : active = 4">
                        <span class="font-medium text-gray-800">Apakah ada batasan jumlah tiket yang bisa dibeli?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{'transform rotate-180': active === 4}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="active === 4" class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            Ya, biasanya ada batasan jumlah tiket yang bisa dibeli per akun. Batasan ini bervariasi tergantung kebijakan penyelenggara konser. Informasi tentang batasan pembelian tiket tersedia pada halaman detail konser. Pembatasan ini bertujuan untuk memberikan kesempatan yang adil bagi semua penggemar untuk membeli tiket.
                        </p>
                    </div>
                </div>

                <!-- Payment -->
                <h2 class="text-xl font-bold text-gray-800 mb-4 mt-8">Pembayaran</h2>

                <!-- Item 5 -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 text-left" @click="active === 5 ? active = 0 : active = 5">
                        <span class="font-medium text-gray-800">Metode pembayaran apa saja yang tersedia?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{'transform rotate-180': active === 5}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="active === 5" class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            KonserKUY menawarkan berbagai metode pembayaran, termasuk:
                        </p>
                        <ul class="list-disc pl-5 mt-2 text-gray-700 space-y-1">
                            <li>Kartu kredit/debit (Visa, Mastercard, JCB)</li>
                            <li>Transfer bank (BCA, Mandiri, BNI, BRI)</li>
                            <li>E-wallet (OVO, GoPay, DANA, LinkAja)</li>
                            <li>Virtual account</li>
                            <li>Minimarket (Alfamart, Indomaret)</li>
                        </ul>
                    </div>
                </div>

                <!-- Item 6 -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 text-left" @click="active === 6 ? active = 0 : active = 6">
                        <span class="font-medium text-gray-800">Berapa lama batas waktu pembayaran?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{'transform rotate-180': active === 6}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="active === 6" class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            Batas waktu pembayaran adalah 1 jam untuk semua metode pembayaran. Jika Anda tidak menyelesaikan pembayaran dalam waktu tersebut, pesanan akan otomatis dibatalkan dan tiket akan dikembalikan ke stok yang tersedia. Pastikan untuk menyelesaikan pembayaran Anda sesegera mungkin untuk mengamankan tiket Anda.
                        </p>
                    </div>
                </div>

                <!-- E-Ticket -->
                <h2 class="text-xl font-bold text-gray-800 mb-4 mt-8">E-Ticket</h2>

                <!-- Item 7 -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 text-left" @click="active === 7 ? active = 0 : active = 7">
                        <span class="font-medium text-gray-800">Kapan saya akan menerima e-ticket?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{'transform rotate-180': active === 7}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="active === 7" class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            E-ticket akan dikirimkan ke email Anda segera setelah pembayaran berhasil dikonfirmasi. Anda juga dapat mengakses e-ticket di akun KonserKUY Anda pada menu "Pesanan Saya". Pastikan untuk memeriksa folder spam jika Anda tidak menerima email e-ticket.
                        </p>
                    </div>
                </div>

                <!-- Item 8 -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 text-left" @click="active === 8 ? active = 0 : active = 8">
                        <span class="font-medium text-gray-800">Bagaimana cara menggunakan e-ticket?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{'transform rotate-180': active === 8}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="active === 8" class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            E-ticket harus ditunjukkan saat masuk ke venue konser. Anda dapat menunjukkannya dalam bentuk digital di smartphone atau mencetak e-ticket tersebut. Pastikan QR code pada e-ticket terlihat jelas untuk dipindai. Bawa juga kartu identitas yang sesuai dengan nama yang tertera pada e-ticket untuk verifikasi.
                        </p>
                    </div>
                </div>

                <!-- Refund -->
                <h2 class="text-xl font-bold text-gray-800 mb-4 mt-8">Pengembalian Dana</h2>

                <!-- Item 9 -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 text-left" @click="active === 9 ? active = 0 : active = 9">
                        <span class="font-medium text-gray-800">Apakah tiket yang sudah dibeli bisa direfund?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{'transform rotate-180': active === 9}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="active === 9" class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            Kebijakan refund tergantung pada kebijakan penyelenggara konser. Umumnya, tiket yang sudah dibeli tidak dapat direfund kecuali jika konser dibatalkan oleh penyelenggara. Informasi lengkap tentang kebijakan refund tersedia pada halaman detail konser. Jika konser dibatalkan, kami akan mengirimkan informasi tentang proses refund melalui email.
                        </p>
                    </div>
                </div>

                <!-- Item 10 -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 text-left" @click="active === 10 ? active = 0 : active = 10">
                        <span class="font-medium text-gray-800">Berapa lama proses refund jika konser dibatalkan?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{'transform rotate-180': active === 10}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="active === 10" class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            Proses refund biasanya membutuhkan waktu 7-14 hari kerja tergantung pada metode pembayaran yang Anda gunakan. Refund akan dikembalikan ke metode pembayaran yang sama saat Anda melakukan pembelian. Kami akan mengirimkan konfirmasi melalui email ketika refund telah diproses.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="mt-12 p-6 bg-gray-100 rounded-lg text-center">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Tidak menemukan jawaban yang Anda cari?</h3>
                <p class="text-gray-600 mb-4">Tim dukungan pelanggan kami siap membantu Anda.</p>
                <a href="{{ route('contact') }}" class="inline-block bg-pink-600 text-white px-6 py-3 rounded-md font-medium hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@endpush 