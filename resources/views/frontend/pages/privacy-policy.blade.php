@extends('frontend.layouts.app')

@section('title', 'Kebijakan Privasi - KonserKUY')

@section('content')
<div class="bg-gray-50">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Kebijakan Privasi</h1>
            <p class="text-lg opacity-90">Bagaimana kami melindungi data pribadi Anda</p>
        </div>
    </div>

    <!-- Privacy Policy Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
            <!-- Last Updated -->
            <div class="mb-8 text-gray-500 text-sm">Terakhir diperbarui: 25 Mei 2023</div>
            
            <!-- Introduction -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Pendahuluan</h2>
                <p class="text-gray-700 mb-4">
                    KonserKUY ("kami", "kita", atau "milik kami") menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, mengolah, dan menyimpan data pribadi Anda saat Anda menggunakan platform kami (situs web dan aplikasi mobile).
                </p>
                <p class="text-gray-700 mb-4">
                    Dengan menggunakan platform KonserKUY, Anda menyetujui praktik yang dijelaskan dalam Kebijakan Privasi ini. Jika Anda tidak setuju dengan Kebijakan Privasi ini, harap jangan gunakan platform kami.
                </p>
            </div>

            <!-- Information We Collect -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi yang Kami Kumpulkan</h2>
                <p class="text-gray-700 mb-4">
                    Kami mengumpulkan beberapa jenis informasi dari pengguna platform KonserKUY:
                </p>
                
                <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3">Informasi Pribadi</h3>
                <p class="text-gray-700 mb-4">
                    Informasi pribadi adalah data yang dapat digunakan untuk mengidentifikasi Anda secara langsung atau tidak langsung. Informasi pribadi yang kami kumpulkan meliputi:
                </p>
                <ul class="list-disc pl-5 text-gray-700 space-y-2">
                    <li>Nama lengkap</li>
                    <li>Alamat email</li>
                    <li>Nomor telepon</li>
                    <li>Alamat pengiriman (jika diperlukan)</li>
                    <li>Informasi pembayaran (kami tidak menyimpan detail kartu kredit secara langsung, tetapi menggunakan penyedia layanan pembayaran pihak ketiga)</li>
                    <li>Tanggal lahir</li>
                    <li>Jenis kelamin</li>
                </ul>
                
                <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3">Informasi Penggunaan</h3>
                <p class="text-gray-700 mb-4">
                    Informasi penggunaan adalah data yang dikumpulkan secara otomatis tentang bagaimana Anda berinteraksi dengan platform kami. Informasi penggunaan yang kami kumpulkan meliputi:
                </p>
                <ul class="list-disc pl-5 text-gray-700 space-y-2">
                    <li>Alamat IP</li>
                    <li>Jenis dan versi browser</li>
                    <li>Jenis perangkat dan sistem operasi</li>
                    <li>Waktu dan tanggal kunjungan</li>
                    <li>Halaman yang Anda kunjungi</li>
                    <li>Riwayat pencarian</li>
                    <li>Preferensi konser</li>
                </ul>
            </div>

            <!-- How We Use Your Information -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Bagaimana Kami Menggunakan Informasi Anda</h2>
                <p class="text-gray-700 mb-4">
                    Kami menggunakan informasi yang kami kumpulkan untuk tujuan berikut:
                </p>
                <ul class="list-disc pl-5 text-gray-700 space-y-2">
                    <li>Memproses dan menyelesaikan pembelian tiket Anda</li>
                    <li>Mengirimkan e-ticket dan informasi acara yang relevan</li>
                    <li>Mengelola akun Anda dan menyediakan layanan pelanggan</li>
                    <li>Mengirimkan pemberitahuan tentang perubahan pada acara atau layanan kami</li>
                    <li>Menyediakan informasi tentang konser dan acara yang mungkin menarik bagi Anda</li>
                    <li>Menganalisis penggunaan platform untuk meningkatkan layanan kami</li>
                    <li>Mencegah penipuan dan aktivitas tidak sah</li>
                    <li>Memenuhi kewajiban hukum atau peraturan</li>
                </ul>
            </div>

            <!-- Sharing Your Information -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Berbagi Informasi Anda</h2>
                <p class="text-gray-700 mb-4">
                    Kami dapat membagikan informasi Anda dengan pihak-pihak berikut:
                </p>
                <ul class="list-disc pl-5 text-gray-700 space-y-2">
                    <li><strong>Penyelenggara Acara:</strong> Informasi yang relevan akan dibagikan dengan penyelenggara acara untuk memfasilitasi kehadiran Anda dan untuk tujuan verifikasi tiket.</li>
                    <li><strong>Penyedia Layanan:</strong> Kami bekerja sama dengan penyedia layanan pihak ketiga (seperti layanan pembayaran, analitik, dan layanan pelanggan) yang membantu kami dalam operasi platform kami.</li>
                    <li><strong>Pihak Berwenang:</strong> Kami dapat membagikan informasi Anda jika diwajibkan oleh hukum atau jika kami percaya bahwa tindakan tersebut diperlukan untuk mematuhi proses hukum atau melindungi hak, properti, atau keselamatan kami, pengguna kami, atau publik.</li>
                </ul>
                <p class="text-gray-700 mt-4">
                    Kami tidak akan menjual informasi pribadi Anda kepada pihak ketiga untuk tujuan pemasaran tanpa persetujuan eksplisit dari Anda.
                </p>
            </div>

            <!-- Cookies and Tracking Technologies -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Cookies dan Teknologi Pelacakan</h2>
                <p class="text-gray-700 mb-4">
                    Platform KonserKUY menggunakan cookies dan teknologi pelacakan serupa untuk meningkatkan pengalaman pengguna dan mengumpulkan informasi tentang bagaimana platform digunakan.
                </p>
                <p class="text-gray-700 mb-4">
                    Cookies adalah file teks kecil yang disimpan di browser atau perangkat Anda saat Anda mengunjungi situs web. Kami menggunakan cookies untuk:
                </p>
                <ul class="list-disc pl-5 text-gray-700 space-y-2">
                    <li>Mengingat preferensi dan setelan Anda</li>
                    <li>Mempertahankan status login Anda</li>
                    <li>Memahami bagaimana Anda berinteraksi dengan platform kami</li>
                    <li>Menganalisis tren dan pola penggunaan</li>
                    <li>Meningkatkan platform kami dan pengalaman pengguna</li>
                </ul>
                <p class="text-gray-700 mt-4">
                    Anda dapat mengatur browser Anda untuk menolak semua atau beberapa cookies, atau untuk memberi tahu Anda saat cookies dikirim. Namun, jika Anda menolak cookies, beberapa bagian dari platform kami mungkin tidak berfungsi dengan baik.
                </p>
            </div>

            <!-- Data Security -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Keamanan Data</h2>
                <p class="text-gray-700 mb-4">
                    Kami mengimplementasikan langkah-langkah keamanan yang sesuai untuk melindungi informasi pribadi Anda dari akses, penggunaan, atau pengungkapan yang tidak sah. Kami menggunakan enkripsi SSL untuk melindungi data yang dikirimkan antara browser Anda dan server kami.
                </p>
                <p class="text-gray-700 mb-4">
                    Meskipun kami berusaha untuk melindungi informasi pribadi Anda, tidak ada metode transmisi melalui internet atau metode penyimpanan elektronik yang 100% aman. Oleh karena itu, kami tidak dapat menjamin keamanan mutlak.
                </p>
            </div>

            <!-- Data Retention -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Penyimpanan Data</h2>
                <p class="text-gray-700 mb-4">
                    Kami akan menyimpan informasi pribadi Anda selama diperlukan untuk memenuhi tujuan yang dijelaskan dalam Kebijakan Privasi ini, kecuali jika diperlukan periode penyimpanan yang lebih lama atau diizinkan oleh hukum.
                </p>
                <p class="text-gray-700 mb-4">
                    Untuk informasi terkait akun, kami akan menyimpan data Anda selama akun Anda aktif. Jika Anda meminta penghapusan akun, kami akan menghapus informasi Anda dalam waktu yang wajar, kecuali jika kami diharuskan untuk menyimpan informasi tertentu untuk tujuan hukum atau bisnis yang sah.
                </p>
            </div>

            <!-- Your Rights -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Hak Anda</h2>
                <p class="text-gray-700 mb-4">
                    Tergantung pada lokasi Anda, Anda mungkin memiliki hak-hak berikut terkait dengan data pribadi Anda:
                </p>
                <ul class="list-disc pl-5 text-gray-700 space-y-2">
                    <li><strong>Hak Akses:</strong> Anda berhak untuk mendapatkan konfirmasi apakah kami memproses data pribadi Anda dan mengakses data tersebut.</li>
                    <li><strong>Hak Perbaikan:</strong> Anda berhak untuk meminta perbaikan data pribadi Anda yang tidak akurat atau tidak lengkap.</li>
                    <li><strong>Hak Penghapusan:</strong> Anda berhak untuk meminta penghapusan data pribadi Anda dalam keadaan tertentu.</li>
                    <li><strong>Hak Pembatasan Pemrosesan:</strong> Anda berhak untuk meminta pembatasan pemrosesan data pribadi Anda dalam keadaan tertentu.</li>
                    <li><strong>Hak Portabilitas Data:</strong> Anda berhak untuk menerima data pribadi Anda dalam format yang terstruktur dan umum digunakan.</li>
                    <li><strong>Hak Keberatan:</strong> Anda berhak untuk mengajukan keberatan terhadap pemrosesan data pribadi Anda dalam keadaan tertentu.</li>
                </ul>
                <p class="text-gray-700 mt-4">
                    Untuk menggunakan hak-hak ini, silakan hubungi kami melalui informasi kontak yang disediakan di bagian "Kontak Kami" di bawah ini.
                </p>
            </div>

            <!-- Children's Privacy -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Privasi Anak</h2>
                <p class="text-gray-700 mb-4">
                    Platform KonserKUY tidak ditujukan untuk anak-anak di bawah usia 13 tahun. Kami tidak secara sengaja mengumpulkan informasi pribadi dari anak-anak di bawah 13 tahun. Jika Anda adalah orangtua atau wali dan percaya bahwa anak Anda telah memberikan kami informasi pribadi, silakan hubungi kami segera.
                </p>
            </div>

            <!-- Changes to This Privacy Policy -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Perubahan pada Kebijakan Privasi Ini</h2>
                <p class="text-gray-700 mb-4">
                    Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu untuk mencerminkan perubahan pada praktik privasi kami. Kami akan memberi tahu Anda tentang perubahan signifikan dengan memposting Kebijakan Privasi baru di platform kami dan, jika memungkinkan, melalui email.
                </p>
                <p class="text-gray-700 mb-4">
                    Kami mendorong Anda untuk secara berkala meninjau Kebijakan Privasi ini untuk tetap mendapatkan informasi tentang bagaimana kami melindungi informasi Anda.
                </p>
            </div>

            <!-- Contact Us -->
            <div class="mt-12">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Kontak Kami</h2>
                <p class="text-gray-700 mb-4">
                    Jika Anda memiliki pertanyaan atau kekhawatiran tentang Kebijakan Privasi ini atau praktik data kami, silakan hubungi kami di:
                </p>
                <p class="text-gray-700">
                    Email: privacy@konserkuy.com<br>
                    Alamat: Jl. Musik Raya No. 88, Jakarta Selatan, DKI Jakarta, Indonesia
                </p>
            </div>
        </div>
    </div>
</div>
@endsection 