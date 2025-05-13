@extends('layouts.app')

@section('title', 'Detail Tiket - KonserKUY')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h4 mb-0">
                            <i class="bi bi-ticket-perforated-fill me-2"></i>
                            Detail Tiket
                        </h1>
                        <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-outline-light">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-4 bg-light d-flex flex-column justify-content-center align-items-center p-4 border-end">
                            <div class="text-center mb-3">
                                <div class="bg-white p-2 border rounded mb-3 mx-auto" style="width: 180px; height: 180px;">
                                    @if($ticket->qr_code)
                                    <img src="data:image/png;base64,{{ $ticket->qr_code }}" alt="QR Code" class="img-fluid">
                                    @else
                                    <div class="d-flex justify-content-center align-items-center h-100 bg-light">
                                        <span class="text-muted">QR Code tidak tersedia</span>
                                    </div>
                                    @endif
                                </div>
                                <span class="badge bg-{{ $ticket->status === 'active' ? 'success' : ($ticket->status === 'used' ? 'secondary' : 'warning') }} mb-2">
                                    {{ $ticket->status === 'active' ? 'Aktif' : ($ticket->status === 'used' ? 'Terpakai' : 'Kadaluarsa') }}
                                </span>
                                <h5 class="mb-0 text-break">{{ $ticket->ticket_code }}</h5>
                            </div>
                            
                            <div class="d-grid gap-2 w-100 mt-3">
                                <a href="{{ route('tickets.download', $ticket->id) }}" class="btn btn-primary">
                                    <i class="bi bi-download me-2"></i>Download E-Ticket
                                </a>
                            </div>
                        </div>
                        
                        <div class="col-md-8 p-4">
                            <h2 class="h4 mb-3">{{ $ticket->orderItem->event->title }}</h2>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="bi bi-calendar-event text-primary fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Tanggal Event</h6>
                                            <p class="mb-0 text-muted">
                                                {{ \Carbon\Carbon::parse($ticket->orderItem->event->date)->format('l, d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="bi bi-clock text-primary fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Waktu</h6>
                                            <p class="mb-0 text-muted">
                                                {{ \Carbon\Carbon::parse($ticket->orderItem->event->date)->format('H:i') }} WIB
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="bi bi-geo-alt text-primary fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Lokasi</h6>
                                            <p class="mb-0 text-muted">{{ $ticket->orderItem->event->location }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="bi bi-ticket-detailed text-primary fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Tipe Tiket</h6>
                                            <p class="mb-0 text-muted">{{ $ticket->orderItem->ticket->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body py-3">
                                    <h5 class="mb-3">Informasi Pemesanan</h5>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Order ID</p>
                                            <p class="mb-0 fw-medium">{{ $ticket->orderItem->order->order_number }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Tanggal Pembelian</p>
                                            <p class="mb-0 fw-medium">
                                                {{ \Carbon\Carbon::parse($ticket->orderItem->order->created_at)->format('d M Y') }}
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Harga</p>
                                            <p class="mb-0 fw-medium">Rp {{ number_format($ticket->orderItem->price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Status Tiket</p>
                                            <p class="mb-0">
                                                <span class="badge bg-{{ $ticket->status === 'active' ? 'success' : ($ticket->status === 'used' ? 'secondary' : 'warning') }}">
                                                    {{ $ticket->status === 'active' ? 'Aktif' : ($ticket->status === 'used' ? 'Terpakai' : 'Kadaluarsa') }}
                                                </span>
                                                @if($ticket->used_at)
                                                <small class="d-block text-muted mt-1">
                                                    Digunakan pada: {{ \Carbon\Carbon::parse($ticket->used_at)->format('d M Y H:i') }}
                                                </small>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                                <div>
                                    <strong>Informasi Penting:</strong>
                                    <p class="mb-0 small">Tunjukkan QR code ini kepada petugas saat memasuki venue. Tiket hanya dapat digunakan satu kali. Jaga kerahasiaan QR code Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 