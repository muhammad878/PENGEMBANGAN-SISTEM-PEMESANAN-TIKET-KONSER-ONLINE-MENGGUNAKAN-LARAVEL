<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">
                            @if ($ticket->order && $ticket->order->event)
                                {{ $ticket->order->event->title }}
                            @else
                                Unknown Event
                            @endif
                        </h3>
                        <p class="text-gray-600 mt-1">
                            @if ($ticket->order && $ticket->order->event)
                                {{ $ticket->order->event->location }}
                            @endif
                        </p>
                    </div>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('tickets.download', $ticket) }}" class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">
                            Download PDF
                        </a>
                        <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Back to List
                        </a>
                    </div>
                </div>
                
                <!-- Ticket Info -->
                <div class="mb-8 md:grid md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-lg font-semibold mb-4 text-gray-800">Ticket Information</h4>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <div class="grid grid-cols-3 mb-4">
                                <div class="col-span-1 text-gray-600 font-medium">Ticket Code</div>
                                <div class="col-span-2 font-semibold">{{ $ticket->code }}</div>
                            </div>
                            
                            <div class="grid grid-cols-3 mb-4">
                                <div class="col-span-1 text-gray-600 font-medium">Status</div>
                                <div class="col-span-2">
                                    @if ($ticket->is_used)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Used</span>
                                    @elseif ($ticket->event_date && $ticket->event_date < now())
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm">Expired</span>
                                    @else
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">Active</span>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($ticket->is_used && $ticket->used_at)
                            <div class="grid grid-cols-3 mb-4">
                                <div class="col-span-1 text-gray-600 font-medium">Used On</div>
                                <div class="col-span-2">{{ $ticket->used_at->format('j F Y, H:i') }}</div>
                            </div>
                            @endif
                            
                            <div class="grid grid-cols-3 mb-4">
                                <div class="col-span-1 text-gray-600 font-medium">Event Date</div>
                                <div class="col-span-2">
                                    @if ($ticket->event_date)
                                        {{ $ticket->event_date->format('j F Y, H:i') }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-3 mb-4">
                                <div class="col-span-1 text-gray-600 font-medium">Purchased On</div>
                                <div class="col-span-2">{{ $ticket->created_at->format('j F Y, H:i') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg mt-6 md:mt-0">
                        <h4 class="text-lg font-semibold mb-4 text-gray-800">Ticket Code</h4>
                        
                        <div class="text-center p-4 bg-white rounded-lg border border-gray-200 mb-4">
                            <div class="flex flex-col items-center">
                                <div class="bg-white p-2 border border-gray-200 rounded-lg mb-2">
                                    <div class="text-2xl font-mono tracking-wider py-4 px-6">{{ $ticket->code }}</div>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">Show this code at the event</p>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-xs text-gray-500">
                                This ticket is for personal use only and cannot be transferred.
                                Please bring a valid ID to the event.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Event Details -->
                @if ($ticket->order && $ticket->order->event)
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h4 class="text-lg font-semibold mb-4 text-gray-800">Event Details</h4>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <div class="grid grid-cols-3 mb-4">
                            <div class="col-span-1 text-gray-600 font-medium">Organizer</div>
                            <div class="col-span-2">{{ $ticket->order->event->user ? $ticket->order->event->user->name : 'Unknown' }}</div>
                        </div>
                        
                        <div class="grid grid-cols-3 mb-4">
                            <div class="col-span-1 text-gray-600 font-medium">Location</div>
                            <div class="col-span-2">{{ $ticket->order->event->location }}</div>
                        </div>
                        
                        <div class="grid grid-cols-3 mb-4">
                            <div class="col-span-1 text-gray-600 font-medium">Date & Time</div>
                            <div class="col-span-2">{{ $ticket->order->event->date->format('j F Y, H:i') }}</div>
                        </div>
                        
                        <div class="grid grid-cols-3">
                            <div class="col-span-1 text-gray-600 font-medium">Description</div>
                            <div class="col-span-2">{{ $ticket->order->event->description }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 