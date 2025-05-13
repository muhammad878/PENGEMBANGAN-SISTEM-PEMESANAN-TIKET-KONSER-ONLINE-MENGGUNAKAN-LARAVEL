@extends('frontend.layouts.app')

@section('title', 'Error - KonserKUY')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-8 text-center">
                <div class="inline-block p-4 bg-red-100 rounded-full mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Terjadi Kesalahan</h1>
                
                <div class="text-gray-600 mb-6">
                    @if(isset($message))
                        <p>{{ $message }}</p>
                    @else
                        <p>Maaf, terjadi kesalahan saat memproses permintaan Anda.</p>
                    @endif
                </div>
                
                <div class="mt-8 flex justify-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Kembali ke Dashboard
                    </a>
                    <a href="{{ route('tickets.hub') }}" class="px-4 py-2 bg-pink-600 text-white rounded-md shadow-sm hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                        Ke Halaman Tiket
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 