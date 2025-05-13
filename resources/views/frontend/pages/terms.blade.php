@extends('frontend.layouts.app')

@section('title', 'Syarat dan Ketentuan - KonserKUY')

@section('content')
<div class="bg-gray-50">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-pink-600 to-purple-600 text-white">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Syarat dan Ketentuan</h1>
            <p class="text-lg opacity-90">Ketentuan penggunaan platform KonserKUY</p>
        </div>
    </div>

    <!-- Terms Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
            <!-- Last Updated -->
            <div class="mb-8 text-gray-500 text-sm">Terakhir diperbarui: 25 Mei 2023</div>
            
            <!-- Introduction -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Pendahuluan</h2>
                <p class="text-gray-700 mb-4">
                    Selamat datang di KonserKUY. Syarat dan Ketentuan ini mengatur penggunaan platform KonserKUY dan layanan yang kami sediakan. Platform KonserKUY mencakup situs web (www.konserkuy.com) dan aplikasi mobile KonserKUY.
                </p>
                <p class="text-gray-700 mb-4">
                    Dengan mengakses atau menggunakan platform KonserKUY, Anda menyetujui untuk terikat oleh Syarat dan Ketentuan ini. Jika Anda tidak setuju dengan bagian apa pun dari ketentuan ini, Anda tidak boleh mengakses platform atau menggunakan layanan kami.
                </p>
            </div>

            <!-- Definitions -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Definisi</h2>
                <ul class="list-disc pl-5 text-gray-700 space-y-2">
                    <li><strong>"KonserKUY", "Kami", "Kita"</strong> merujuk pada platform KonserKUY dan perusahaan pengelolanya.</li>
                    <li><strong>"Platform"</strong> merujuk pada situs web dan aplikasi mobile KonserKUY.</li>
                    <li><strong>"Pengguna", "Anda"</strong> merujuk pada individu yang mengakses atau menggunakan platform KonserKUY.</li>
                    <li><strong>"Penyelenggara"</strong> merujuk pada promotor, organisasi, atau individu yang menjual tiket konser melalui platform KonserKUY.</li>
                    <li><strong>"Konser"</strong> merujuk pada pertunjukan musik, festival, atau acara hiburan lainnya yang dijual tiketnya melalui platform KonserKUY.</li>
                    <li><strong>"Tiket"</strong> merujuk pada bukti hak masuk ke suatu konser.</li>
                </ul>
            </div>

            <!-- Account Registration -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Pendaftaran Akun</h2>
                <p class="text-gray-700 mb-4">
                    Untuk menggunakan beberapa fitur dari platform kami, Anda mungkin perlu membuat akun. Ketika mendaftar, Anda harus memberikan informasi yang akurat dan lengkap. Anda bertanggung jawab untuk menjaga kerahasiaan akun dan password Anda dan untuk membatasi akses ke komputer atau perangkat mobile Anda.
                </p>
                <p class="text-gray-700 mb-4">
                    Anda setuju untuk menerima tanggung jawab atas semua aktivitas yang terjadi di bawah akun atau password Anda. Anda harus segera memberi tahu KonserKUY tentang penggunaan tidak sah akun Anda atau pelanggaran keamanan lainnya.
                </p>
                <p class="text-gray-700 mb-4">
                    KonserKUY berhak untuk menolak layanan, menghapus atau mengedit konten, atau membatalkan akun atas kebijakan kami sendiri.
                </p>
            </div>

            <!-- Ticket Purchases -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Pembelian Tiket</h2>
                <p class="text-gray-700 mb-4">
                    Semua tiket yang dijual melalui platform KonserKUY tunduk pada ketersediaan. KonserKUY bertindak sebagai agen penjualan untuk para Penyelenggara, dan tidak bertanggung jawab atas penyelenggaraan konser itu sendiri.
                </p>
                <p class="text-gray-700 mb-4">
                    Harga tiket ditentukan oleh Penyelenggara dan mungkin termasuk biaya layanan KonserKUY. Semua harga termasuk pajak yang berlaku kecuali dinyatakan lain.
                </p>
                <p class="text-gray-700 mb-4">
                    Setelah menyelesaikan pembelian, Anda akan menerima tiket elektronik (e-ticket) melalui email atau di akun KonserKUY Anda. E-ticket ini merupakan bukti sah untuk masuk ke konser. Pengguna bertanggung jawab untuk memeriksa rincian tiket seperti tanggal, waktu, dan tempat konser.
                </p>
            </div>

            <!-- Refund Policy -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Kebijakan Pengembalian Dana</h2>
                <p class="text-gray-700 mb-4">
                    Tiket yang sudah dibeli umumnya tidak dapat dikembalikan, ditukar, atau dibatalkan kecuali konser dibatalkan oleh Penyelenggara. Dalam hal konser dibatalkan oleh Penyelenggara, kebijakan pengembalian dana dari Penyelenggara yang bersangkutan akan berlaku.
                </p>
                <p class="text-gray-700 mb-4">
                    KonserKUY akan memfasilitasi proses pengembalian dana sesuai dengan kebijakan Penyelenggara. Pengembalian dana biasanya akan diproses melalui metode pembayaran asli dan memerlukan waktu 7-14 hari kerja, tergantung pada kebijakan penyedia layanan pembayaran Anda.
                </p>
            </div>

            <!-- Prohibited Activities -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Aktivitas yang Dilarang</h2>
                <p class="text-gray-700 mb-4">
                    Anda setuju untuk tidak menggunakan platform KonserKUY untuk:
                </p>
                <ul class="list-disc pl-5 text-gray-700 space-y-2">
                    <li>Melanggar hukum atau peraturan yang berlaku.</li>
                    <li>Melanggar hak kekayaan intelektual KonserKUY atau pihak ketiga.</li>
                    <li>Menjual kembali tiket dengan harga yang lebih tinggi (scalping).</li>
                    <li>Mendistribusikan virus komputer atau kode berbahaya lainnya.</li>
                    <li>Mengumpulkan informasi atau data pribadi pengguna lain tanpa izin.</li>
                    <li>Menganggu atau merusak layanan platform KonserKUY.</li>
                </ul>
            </div>

            <!-- Intellectual Property -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Hak Kekayaan Intelektual</h2>
                <p class="text-gray-700 mb-4">
                    Semua konten yang terdapat dalam platform KonserKUY, termasuk teks, grafik, logo, ikon, gambar, klip audio, unduhan digital, kompilasi data, dan perangkat lunak, adalah milik KonserKUY atau pemilik konten yang telah memberikan lisensi kepada kami dan dilindungi oleh undang-undang hak cipta Indonesia dan internasional.
                </p>
                <p class="text-gray-700 mb-4">
                    Penggunaan konten tersebut tanpa izin tertulis dari KonserKUY atau pemilik konten dilarang.
                </p>
            </div>

            <!-- Limitation of Liability -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Batasan Tanggung Jawab</h2>
                <p class="text-gray-700 mb-4">
                    KonserKUY tidak bertanggung jawab atas kerugian langsung, tidak langsung, insidental, konsekuensial, atau khusus yang timbul dari atau sehubungan dengan penggunaan platform kami atau layanan kami, termasuk namun tidak terbatas pada:
                </p>
                <ul class="list-disc pl-5 text-gray-700 space-y-2">
                    <li>Pembatalan atau penundaan konser oleh Penyelenggara.</li>
                    <li>Perubahan lineup, tanggal, waktu, atau lokasi konser.</li>
                    <li>Masalah yang terkait dengan venue konser.</li>
                    <li>Kehilangan atau pencurian tiket.</li>
                    <li>Penggunaan platform KonserKUY yang tidak sah.</li>
                </ul>
            </div>

            <!-- Changes to Terms -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Perubahan Syarat dan Ketentuan</h2>
                <p class="text-gray-700 mb-4">
                    KonserKUY berhak untuk mengubah Syarat dan Ketentuan ini kapan saja. Perubahan tersebut akan efektif segera setelah diposting di platform. Penggunaan yang berkelanjutan dari platform setelah perubahan tersebut merupakan penerimaan Anda terhadap perubahan tersebut.
                </p>
                <p class="text-gray-700 mb-4">
                    Kami akan berusaha untuk memberi tahu pengguna tentang perubahan signifikan, namun Anda diharapkan untuk secara berkala meninjau Syarat dan Ketentuan ini.
                </p>
            </div>

            <!-- Governing Law -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Hukum yang Berlaku</h2>
                <p class="text-gray-700 mb-4">
                    Syarat dan Ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum Republik Indonesia. Setiap perselisihan yang timbul dari atau sehubungan dengan Syarat dan Ketentuan ini akan diselesaikan melalui arbitrase di Jakarta, Indonesia, sesuai dengan Peraturan Badan Arbitrase Nasional Indonesia yang berlaku pada saat pengajuan permohonan arbitrase.
                </p>
            </div>

            <!-- Contact Information -->
            <div class="mt-12">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Kontak Kami</h2>
                <p class="text-gray-700 mb-4">
                    Jika Anda memiliki pertanyaan tentang Syarat dan Ketentuan ini, silakan hubungi kami di:
                </p>
                <p class="text-gray-700">
                    Email: legal@konserkuy.com<br>
                    Alamat: Jl. Musik Raya No. 88, Jakarta Selatan, DKI Jakarta, Indonesia
                </p>
            </div>
        </div>
    </div>
</div>
@endsection 