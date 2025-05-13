@extends('frontend.layouts.app')

@section('title', $event->title . ' - KonserKUY')

@section('content')
<div class="bg-gray-50">
    <!-- Event Details -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Event Header -->
            <div class="relative">
                @php
                    // Poster event selalu diutamakan sebagai gambar utama
                    if ($event->poster_path) {
                        // Gunakan path langsung karena sudah di direktori public
                        $imagePath = $event->poster_path;
                        // Log info untuk debugging
                        \Illuminate\Support\Facades\Log::info('Event detail poster display attempt: ' . $imagePath);
                    } else {
                        $imagePath = 'images/default-event.jpg';
                    }
                @endphp
                <img src="{{ asset($imagePath) }}" 
                    alt="{{ $event->title }}" class="w-full h-64 md:h-96 object-cover"
                    onerror="this.onerror=null; this.src='{{ asset('images/default-event.jpg') }}'; console.log('Image failed to load, using default')">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 text-white">
                    <div class="flex items-center mb-2">
                        <span class="px-3 py-1 bg-gradient-primary text-white text-sm font-medium rounded-full mr-2">
                            @php
                                $categoryName = 'Uncategorized';
                                if ($event->category_id) {
                                    $category = App\Models\Category::find($event->category_id);
                                    if ($category) {
                                        $categoryName = $category->name;
                                    }
                                }
                                echo $categoryName;
                            @endphp
                        </span>
                        <span class="text-sm opacity-90">{{ $event->date->format('l, d F Y') }}</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $event->title }}</h1>
                    <p class="flex items-center text-sm md:text-base opacity-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        {{ $event->location }}
                    </p>
                </div>
            </div>

            <!-- Event Body -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Event Details Column -->
                    <div class="lg:col-span-2">
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Deskripsi Event</h2>
                            <div class="prose max-w-none text-gray-700">
                                {{ $event->description }}
                            </div>
                        </div>
                        
                        <!-- Google Maps Venue -->
                        @if(isset($event->maps_link) && $event->maps_link)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Lokasi {{ $event->location }}</h2>
                            <div class="maps-container rounded-lg overflow-hidden">
                                <style>
                                    .maps-container iframe {
                                        width: 100%;
                                        min-height: 350px;
                                        border: 0;
                                    }
                                </style>
                                {!! $event->maps_link !!}
                            </div>
                        </div>
                        @endif

                        <!-- Venue Image -->
                        @if(isset($event->venue_image_path) && $event->venue_image_path)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Foto Venue</h2>
                            <div class="rounded-lg overflow-hidden shadow-md">
                                <img src="{{ asset($event->venue_image_path) }}" 
                                    alt="Venue {{ $event->location }}" class="w-full h-auto"
                                    onerror="this.onerror=null; this.src='{{ asset('images/default-event.jpg') }}'; console.log('Venue image failed to load, using default')">
                            </div>
                        </div>
                        @endif
                        
                        <!-- Organizer Info -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Penyelenggara</h2>
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-gray-700 font-bold">
                                        @php
                                            // Get user who created the event
                                            $user = \App\Models\User::find($event->user_id);
                                            if ($user) {
                                                echo substr($user->name, 0, 1);
                                            } else {
                                                echo 'A';
                                            }
                                        @endphp
                                    </span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">
                                        @php
                                            if ($user) {
                                                echo $user->name;
                                            } else {
                                                echo 'Admin KonserKUY';
                                            }
                                        @endphp
                                    </h3>
                                    <p class="text-gray-600 text-sm">Penyelenggara</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Column -->
                    <div>
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 sticky top-8">
                            <h2 class="text-xl font-bold text-gray-800 mb-4">Tiket</h2>
                            
                            @if(isset($event->tickets) && count($event->tickets) > 0)
                                <div class="space-y-4 mb-6">
                                    @foreach($event->tickets as $ticket)
                                        <div class="border border-gray-200 rounded-md p-4 {{ $ticket->isAvailable ? 'bg-white hover:border-primary-400 transition-all' : 'bg-gray-100' }}">
                                            <div class="flex justify-between items-start mb-2">
                                                <h3 class="font-bold text-gray-800">{{ $ticket->ticket_type }}</h3>
                                                <span class="font-bold text-gradient">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm text-gray-500">
                                                    {{ $ticket->quota - $ticket->sold }} tersisa dari {{ $ticket->quota }}
                                                </span>
                                                @if($ticket->isAvailable)
                                                    <div class="flex items-center">
                                                        <label for="ticket_{{ $ticket->id }}" class="mr-3 text-sm font-medium text-gray-700">Jumlah:</label>
                                                        <select id="ticket_{{ $ticket->id }}" name="ticket_quantities[{{ $ticket->id }}]" class="ticket-quantity w-16 rounded-md border-gray-300 focus:ring-primary-500 focus:border-primary-500 text-sm">
                                                            <option value="0">0</option>
                                                            @for($i = 1; $i <= min(10, $ticket->quota - $ticket->sold); $i++)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                @else
                                                    <span class="px-3 py-1 bg-gray-300 text-gray-600 rounded text-sm">Habis</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex justify-center">
                                    <form id="checkout-form" method="POST" action="{{ route('cart.add-multiple') }}">
                                        @csrf
                                        <input type="hidden" name="replace_cart" value="1">
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                        
                                        @foreach($event->tickets as $ticket)
                                            <input type="hidden" name="ticket_ids[]" value="{{ $ticket->id }}">
                                            <input type="hidden" name="quantities[]" id="quantity_{{ $ticket->id }}" value="0">
                                        @endforeach

                                        @if(session('error'))
                                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                                                <span class="block sm:inline">{{ session('error') }}</span>
                                            </div>
                                        @endif

                                        @if($errors->any())
                                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <button type="button" id="submit-button" onclick="validateAndSubmit()" class="px-5 py-2 bg-gradient-primary text-white font-medium rounded-full hover:shadow-lg transition-all inline-flex items-center justify-center">
                                            <span>Checkout Sekarang</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                <!-- Add JavaScript to update the form fields -->
                                <script>
                                    // Debug messages to see what's going on
                                    console.log('Event detail page loaded');
                                    
                                    // Update form fields when page loads
                                    document.addEventListener('DOMContentLoaded', function() {
                                        console.log('DOM loaded - initializing ticket form');
                                        console.log('Available tickets:', JSON.stringify(Array.from(document.querySelectorAll('.ticket-quantity')).map(el => ({ id: el.id, value: el.value }))));
                                        updateHiddenFields();
                                    });
                                    
                                    // Update hidden fields based on dropdown values
                                    function updateHiddenFields() {
                                        const selects = document.querySelectorAll('.ticket-quantity');
                                        selects.forEach(function(select) {
                                            const ticketId = select.id.replace('ticket_', '');
                                            const hiddenField = document.getElementById('quantity_' + ticketId);
                                            if (hiddenField) {
                                                hiddenField.value = select.value;
                                                console.log('Updated ticket ' + ticketId + ' quantity to ' + select.value);
                                            } else {
                                                console.error('Hidden field not found for ticket ' + ticketId);
                                            }
                                        });
                                    }
                                    
                                    // Attach change event to all dropdowns
                                    const dropdowns = document.querySelectorAll('.ticket-quantity');
                                    dropdowns.forEach(function(dropdown) {
                                        dropdown.addEventListener('change', function() {
                                            console.log('Dropdown ' + dropdown.id + ' changed to ' + dropdown.value);
                                            updateHiddenFields();
                                        });
                                    });
                                    
                                    // Validate and submit form
                                    function validateAndSubmit() {
                                        // Update all hidden fields first
                                        updateHiddenFields();
                                        
                                        // Check if at least one ticket is selected
                                        const quantities = document.querySelectorAll('input[name="quantities[]"]');
                                        let totalQuantity = 0;
                                        
                                        quantities.forEach(function(input) {
                                            totalQuantity += parseInt(input.value || 0);
                                            console.log('Quantity for ' + input.id + ' = ' + input.value);
                                        });
                                        
                                        console.log('Total ticket quantity: ' + totalQuantity);
                                        
                                        if (totalQuantity === 0) {
                                            alert('Pilih minimal 1 tiket untuk melanjutkan');
                                            return;
                                        }
                                        
                                        // Get the form element
                                        const form = document.getElementById('checkout-form');
                                        
                                        // Log form data for debugging
                                        console.log('Form action: ' + form.action);
                                        console.log('Form method: ' + form.method);
                                        console.log('Event ID: ' + document.querySelector('input[name="event_id"]').value);
                                        console.log('CSRF Token: ' + document.querySelector('input[name="_token"]').value);
                                        
                                        // Add extra debug information
                                        const eventId = document.querySelector('input[name="event_id"]').value;
                                        console.log('Ticket info:');
                                        quantities.forEach(function(input, index) {
                                            const qty = parseInt(input.value || 0);
                                            if (qty > 0) {
                                                const ticketId = input.id.replace('quantity_', '');
                                                console.log(`- Ticket ID: ${ticketId}, Event ID: ${eventId}, Quantity: ${qty}`);
                                            }
                                        });
                                        
                                        // Set a debug value to make sure the form is submitted
                                        const debugInput = document.createElement('input');
                                        debugInput.type = 'hidden';
                                        debugInput.name = 'debug';
                                        debugInput.value = 'true';
                                        form.appendChild(debugInput);
                                        
                                        console.log('Submitting form with ' + totalQuantity + ' tickets...');
                                        
                                        // Submit the form
                                        form.submit();
                                        
                                        // Show processing message
                                        document.getElementById('submit-button').disabled = true;
                                        document.getElementById('submit-button').innerHTML = 'Memproses...';
                                    }
                                </script>
                            @else
                                <div class="text-center py-8 bg-white rounded-lg border border-gray-200">
                                    <div class="bg-gray-100 rounded-full p-4 inline-flex mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 mb-2">Informasi tiket belum tersedia</p>
                                    <p class="text-gray-500 text-sm">Penjualan tiket akan segera dibuka</p>
                                </div>
                            @endif
                            
                            <div class="mt-6">
                                <div class="mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-800 font-medium">Tanggal</p>
                                        <p class="text-sm text-gray-600">{{ $event->date->format('d F Y - H:i') }} WIB</p>
                                    </div>
                                </div>
                                <div class="mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-800 font-medium">Lokasi</p>
                                        <p class="text-sm text-gray-600">{{ $event->location }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-800 font-medium">Kategori</p>
                                        <p class="text-sm text-gray-600">
                                            @php
                                                $categoryName = 'Uncategorized';
                                                if ($event->category_id) {
                                                    $category = App\Models\Category::find($event->category_id);
                                                    if ($category) {
                                                        $categoryName = $category->name;
                                                    }
                                                }
                                                echo $categoryName;
                                            @endphp
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Events -->
    @if($relatedEvents->count() > 0)
    <div class="container mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Konser Terkait</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedEvents as $relatedEvent)
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-lift transition-all duration-300">
                <a href="{{ route('events.show', $relatedEvent->slug) }}">
                    @php
                        // Cek jika poster_path ada untuk related event
                        if ($relatedEvent->poster_path) {
                            // Gunakan path langsung karena sudah di direktori public
                            $relatedImagePath = $relatedEvent->poster_path;
                            // Log info untuk debugging
                            \Illuminate\Support\Facades\Log::info('Related event poster display attempt: ' . $relatedImagePath);
                        } else {
                            $relatedImagePath = 'images/default-event.jpg';
                        }
                    @endphp
                    <img src="{{ asset($relatedImagePath) }}" 
                        alt="{{ $relatedEvent->title }}" class="w-full h-48 object-cover"
                        onerror="this.onerror=null; this.src='{{ asset('images/default-event.jpg') }}'; console.log('Related image failed to load, using default')">
                </a>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-2 py-1 bg-gradient-primary text-white text-xs font-medium rounded-full">
                            @php
                                $categoryName = 'Uncategorized';
                                if ($relatedEvent->category_id) {
                                    $category = App\Models\Category::find($relatedEvent->category_id);
                                    if ($category) {
                                        $categoryName = $category->name;
                                    }
                                }
                                echo $categoryName;
                            @endphp
                        </span>
                        <span class="text-gray-700 text-sm">{{ $relatedEvent->date->format('d M Y') }}</span>
                    </div>
                    <a href="{{ route('events.show', $relatedEvent->slug) }}" class="block">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 hover:text-primary-600 transition">{{ $relatedEvent->title }}</h3>
                    </a>
                    <p class="text-gray-600 text-sm mb-3">{{ \Illuminate\Support\Str::limit($relatedEvent->description, 80) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gradient">Rp {{ number_format($relatedEvent->ticket_price, 0, ',', '.') }}</span>
                        <a href="{{ route('events.show', $relatedEvent->slug) }}" class="text-sm font-medium text-primary-600 hover:text-primary-700">Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection 