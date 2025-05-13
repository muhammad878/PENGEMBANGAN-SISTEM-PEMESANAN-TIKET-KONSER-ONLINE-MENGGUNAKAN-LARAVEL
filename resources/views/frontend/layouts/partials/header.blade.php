<!-- Navigation Links - Desktop -->
                    <div class="hidden md:ml-10 md:flex md:items-center md:space-x-6">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors">Home</a>
                        <a href="{{ route('events') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors">Events</a>
                        <a href="{{ route('categories') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors">Categories</a>
                        <a href="{{ route('venues') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors">Venues</a>
                        <a href="{{ route('about') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors">About</a>
                        <a href="{{ route('contact') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors">Contact</a>
                        
                        <!-- Cart Icon -->
                        <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            @php
                                $cartCount = session()->has('cart') ? count(session('cart')) : 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-gradient-primary rounded-full">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </div>

                    <!-- Auth / Register -->
                    <div class="hidden md:flex items-center ml-auto">
                        @auth 