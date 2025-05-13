@extends('layouts.admin')

@section('header')
    Detail Event
@endsection

@section('content')
    <div class="mb-6">
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.events.validation') }}" class="text-indigo-600 hover:text-indigo-900">
                ← Kembali ke Daftar Event
            </a>
        </div>
    </div>

    <!-- Detail Event -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $event->name ?? 'Detail Event' }}</h2>
                    <div class="text-sm text-gray-500">
                        Diajukan pada {{ isset($event->created_at) ? $event->created_at->format('d M Y H:i') : '-' }}
                    </div>
                </div>
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    Menunggu Persetujuan
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="md:col-span-2">
                    <div class="space-y-6">
                        <!-- Banner Event -->
                        <div>
                            <img src="{{ $event->banner_url ?? 'https://via.placeholder.com/800x400' }}" 
                                alt="{{ $event->name ?? 'Event Banner' }}" 
                                class="w-full h-64 object-cover rounded-lg">
                        </div>

                        <!-- Deskripsi Event -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Deskripsi Event</h3>
                            <div class="prose max-w-none text-gray-700">
                                {!! $event->description ?? 'Tidak ada deskripsi' !!}
                            </div>
                        </div>

                        <!-- Lineup / Pengisi Acara -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Lineup / Pengisi Acara</h3>
                            <div class="text-gray-700">
                                {!! $event->lineup ?? 'Tidak ada informasi pengisi acara' !!}
                            </div>
                        </div>

                        <!-- Tiket -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Tiket</h3>
                            @if(isset($event->tickets) && count($event->tickets) > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Jenis Tiket
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Harga
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Kuota
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Deskripsi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($event->tickets as $ticket)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $ticket->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $ticket->quota }}
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        {{ $ticket->description ?? '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500">Tidak ada informasi tiket</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Informasi Event -->
                <div class="md:col-span-1 space-y-6">
                    <!-- Informasi Penyelenggara -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Penyelenggara</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-full mr-2" 
                                    src="{{ $event->organizer_photo_url ?? 'https://via.placeholder.com/100' }}" 
                                    alt="{{ $event->organizer_name }}">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $event->organizer_name ?? '-' }}</div>
                                    <div class="text-sm text-gray-500">{{ $event->organizer_email ?? '-' }}</div>
                                </div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Telepon:</div>
                                <div class="text-sm text-gray-900">{{ $event->organizer_phone ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Event -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Detail Event</h3>
                        <div class="space-y-2">
                            <div>
                                <div class="text-sm text-gray-500">Tanggal & Waktu:</div>
                                <div class="text-sm text-gray-900">
                                    {{ $event->event_date ?? '-' }}, {{ $event->event_time ?? '-' }}
                                </div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Lokasi:</div>
                                <div class="text-sm text-gray-900">{{ $event->location ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Kategori:</div>
                                <div class="text-sm text-gray-900">{{ $event->category ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Kapasitas:</div>
                                <div class="text-sm text-gray-900">{{ $event->capacity ?? '-' }} orang</div>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Pendukung -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Dokumen Pendukung</h3>
                        <div class="space-y-2">
                            @if(isset($event->documents) && count($event->documents) > 0)
                                @foreach($event->documents as $document)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span class="text-sm text-gray-900">{{ $document->name }}</span>
                                        </div>
                                        <a href="{{ $document->url }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-900">
                                            Lihat
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500">Tidak ada dokumen pendukung</p>
                            @endif
                        </div>
                    </div>

                    <!-- Validasi Event -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Validasi Event</h3>
                        <div class="space-y-4">
                            <form action="{{ route('admin.events.approve', $event->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Setujui Event
                                </button>
                            </form>
                            
                            <button type="button" onclick="openRejectModal({{ $event->id }})" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Tolak Event
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tolak Event -->
    <div id="rejectModal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="rejectForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Tolak Event
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Harap berikan alasan penolakan event ini. Alasan ini akan dikirimkan ke penyelenggara.
                                    </p>
                                    <div class="mt-4">
                                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                                        <textarea id="rejection_reason" name="rejection_reason" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Tolak Event
                        </button>
                        <button type="button" onclick="closeRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(eventId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            
            form.action = `/admin/events/${eventId}/reject`;
            modal.classList.remove('hidden');
        }
        
        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
        }
    </script>
@endsection 