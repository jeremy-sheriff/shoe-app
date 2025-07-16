<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dr-MorchCrafts - Custom Shoe Design.</title>

    <!-- SplideJS Assets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/css/splide.min.css"/>


    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #4B0082; /* Indigo */
            --secondary: #D4D4D8; /* Gold */
            --accent: #D4AF37; /* Deeper Gold */
            --light: #F5F5F5; /* Soft background */
            --dark: #121212; /* Harsh on large sections */
        }


        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
        }

        .btn {
            @apply inline-block px-6 py-3 rounded-full font-medium transition-all;
        }
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        .btn-primary:hover {
            background-color: #ff5252;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
        }
        .btn-outline {
            border: 2px solid var(--dark);
            color: var(--dark);
        }
        .btn-outline:hover {
            background-color: var(--dark);
            color: white;
        }
    </style>



    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body class="antialiased">


<!-- Navigation -->
<nav class="py-6 px-6 md:px-12 flex justify-between items-center bg-white shadow-sm sticky top-0 z-50">
    <div class="text-2xl font-bold">
        <span class="text-primary">Dr-Morch</span><span class="text-secondary">Crafts</span>
    </div>

    @if (Route::has('login'))
        <div class="flex items-center space-x-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-outline">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="hover:text-primary">Login</a>
                {{--                @if (Route::has('register'))--}}
                {{--                    <a href="{{ route('register') }}" class="btn btn-primary">Cart</a>--}}
                {{--                @endif--}}
            @endauth
        </div>
    @endif
</nav>


<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">

            <!-- Track Order Button - Left Side -->
            <div class="flex items-center">
                <button
                    onclick="document.getElementById('hero-section').scrollIntoView({ behavior: 'smooth' })"
                    class="bg-black text-white font-semibold px-3 py-2 md:px-6 md:py-3 rounded-lg hover:bg-gray-800 transition-colors duration-200 shadow-md hover:shadow-lg transform hover:scale-105 text-sm md:text-base"
                >
                    <span class="hidden sm:inline">Track your Order</span>
                    <span class="sm:hidden">Track</span>
                </button>
            </div>

            <!-- Mobile Menu Button -->
            <button
                id="mobile-menu-button"
                class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                onclick="toggleMobileMenu()"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Desktop Categories - Centered -->
            <div class="hidden md:flex justify-center space-x-8 w-full md:w-auto">
                <a href="/"
                   class="font-medium text-gray-700 hover:text-primary hover:underline transition-all duration-300 ease-in-out relative py-2 px-3 rounded-md hover:bg-gray-50 hover:shadow-sm transform hover:scale-105">
                    All
                </a>
                @foreach ($categories as $category)
                    <a href="{{ url('/?category=' . $category->id) }}"
                       class="font-medium text-gray-700 hover:text-primary hover:underline transition-all duration-300 ease-in-out relative py-2 px-3 rounded-md hover:bg-gray-50 hover:shadow-sm transform hover:scale-105">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Mobile Menu - Hidden by default -->
        <div id="mobile-menu" class="md:hidden hidden border-t border-gray-200 mt-4 pt-4 pb-4">
            <div class="flex flex-col space-y-3">
                <a href="/"
                   class="font-medium text-gray-700 hover:text-primary hover:bg-gray-50 transition-all duration-300 ease-in-out py-3 px-4 rounded-lg">
                    All
                </a>
                @foreach ($categories as $category)
                    <a href="{{ url('/?category=' . $category->id) }}"
                       class="font-medium text-gray-700 hover:text-primary hover:bg-gray-50 transition-all duration-300 ease-in-out py-3 px-4 rounded-lg">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const menuButton = document.getElementById('mobile-menu-button');

        if (mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.remove('hidden');
            // Change hamburger to X icon
            menuButton.innerHTML = `
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        `;
        } else {
            mobileMenu.classList.add('hidden');
            // Change back to hamburger icon
            menuButton.innerHTML = `
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        `;
        }
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function (event) {
        const mobileMenu = document.getElementById('mobile-menu');
        const menuButton = document.getElementById('mobile-menu-button');

        if (!mobileMenu.contains(event.target) && !menuButton.contains(event.target)) {
            mobileMenu.classList.add('hidden');
            menuButton.innerHTML = `
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        `;
        }
    });
</script>

<!-- Shopping Section -->
<section class=" dark:bg-zinc-900 py-3 px-6 md:px-20">

    <div class="grid gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @foreach ($products as $index => $product)
            <div class="bg-white dark:bg-zinc-800 p-1 rounded-xl shadow hover:shadow-lg transition">
                {{-- Splide Carousel --}}
                @if($product->images->count())
                    <div id="splide-{{ $index }}" class="splide mb-2">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($product->images as $image)
                                    <li class="splide__slide">
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}"
                                             class="w-full h-56 object-cover rounded-lg">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image"
                         class="w-full h-56 object-cover rounded-lg mb-4">
                @endif

                {{-- Product Info --}}
                <h3 class="text-xl font-semibold text-zinc-800 dark:text-white mb-2 p-4">{{ $product->name }}</h3>
                <p class="text-zinc-600 dark:text-zinc-300 text-sm mb-4 p-4">{{ $product->description }}</p>
                <div class="flex items-center justify-between p-6">
                    <span
                        class="text-lg font-bold text-primary dark:text-white">KSh {{ number_format($product->price, 2) }}</span>
                    <a href="{{ route('item.show', $product->slug) }}"
                       class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    >View</a>
                </div>
            </div>
        @endforeach
    </div>
</section>


<!-- Wavy Divider -->
<div class="relative z-0">
    <svg class="block w-full" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path fill="var(--secondary)"
              d="M0,160L80,165.3C160,171,320,181,480,170.7C640,160,800,128,960,122.7C1120,117,1280,139,1360,149.3L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"/>
    </svg>
</div>

<!-- Hero Section -->
<section id="hero-section" style="background-color: var(--secondary); color: var(--dark);"
         class="hero bg-gradient-to-br from-primary to-secondary text-black px-6 md:px-20">
    <div class="flex flex-col md:flex-row items-center gap-12">
        <div class="hero-content text-center md:text-left md:w-1/2 w-full">
            <h1 class="text-6xl font-extrabold leading-tight mb-6">
                Design Your Dream <span class="text-accent">Shoe</span>
            </h1>
            <p class="text-lg mb-8">
                Craft personalized footwear that speaks your vibe, built with top-tier materials and unmatched care.
            </p>

            <div class="flex justify-center md:justify-start gap-4 mb-6 flex-wrap">
                <a href="#" class="px-6 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600 transition">Start
                    Designing</a>
                <a href="#"
                   class="px-6 py-2 border border-black text-black font-semibold rounded hover:bg-black hover:text-white transition">View
                    Gallery</a>
            </div>


            <div id="order-tracking" class="flex flex-col gap-4">
                <livewire:order-tracking-component/>
            </div>
        </div>

        <div class="hero-image md:w-1/2 w-full py-6">
            <img height="400px" width="600px"
                 src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28?auto=format&fit=crop&w=800&q=80"
                 alt="Custom Shoes" class="rounded-3xl shadow-2xl w-full max-w-lg mx-auto">
        </div>
    </div>
</section>






<!-- Features Section -->
<section class="py-24 bg-white px-6 md:px-20">
    <div class="text-center mb-16">
        <h2 class="text-5xl font-bold mb-4 text-secondary">Why Choose Dr-MorchCrafts?</h2>
        <p class="max-w-2xl mx-auto text-accent">
            Seamless experience from design to doorstep — quality, creativity, and quick delivery in one place.
        </p>
    </div>
    <div class="grid gap-10 md:grid-cols-3">
        <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition">
            <div class="text-5xl mb-4 text-primary text-center">🎨</div>
            <h3 class="text-2xl font-bold mb-3 text-center text-dark">Easy Design Tool</h3>
            <p class="text-center text-dark">Visual drag-and-drop designer tailored for your imagination. No experience
                required.</p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition">
            <div class="text-5xl mb-4 text-secondary text-center">👟</div>
            <h3 class="text-2xl font-bold mb-3 text-center text-dark">Premium Materials</h3>
            <p class="text-center text-dark">Only the finest — comfort, durability, and elegance in every pair we
                craft.</p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition">
            <div class="text-5xl mb-4 text-primary text-center">🚀</div>
            <h3 class="text-2xl font-bold mb-3 text-center text-dark">Fast Production</h3>
            <p class="text-center text-dark">Your custom shoes, crafted and delivered in record time — as fast as 14
                days!</p>
        </div>
    </div>
</section>







<section class="bg-white dark:bg-dark text-dark dark:text-white py-24 text-center transition-all duration-300">
    <h2 class="text-4xl md:text-5xl font-bold mb-6">Step Into Your Story</h2>
    <p class="mb-10 text-lg">From vision to reality — start creating shoes that reflect you.</p>
    <a href="#" class="btn btn-primary text-lg">Place Your Custom Order</a>
</section>


<!-- Footer -->
<footer class="bg-gray-900 text-white py-16 px-6 md:px-20">
    <div class="grid md:grid-cols-4 gap-12">
        <div>
            <h3 class="text-2xl font-bold mb-4 text-primary">Dr-MorchCrafts</h3>
            <p>Footwear redefined by you. Designed with love. Built with pride.</p>

        </div>
        <div>
            <h4 class="text-lg font-semibold mb-3">Explore</h4>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-primary">About</a></li>
                <li><a href="#" class="hover:text-primary">Gallery</a></li>
                <li><a href="#" class="hover:text-primary">Design Tool</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-lg font-semibold mb-3">Support</h4>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-primary">Help Center</a></li>
                <li><a href="#" class="hover:text-primary">Shipping & Returns</a></li>
                <li><a href="#" class="hover:text-primary">Contact Us</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-lg font-semibold mb-3">Connect</h4>
            <div class="flex gap-4 text-xl">
                <a href="#" class="hover:text-primary"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-primary"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-primary"><i class="fab fa-facebook"></i></a>
            </div>
        </div>
    </div>
    <div class="text-center text-sm mt-16 border-t pt-6 border-gray-700">
        &copy; 2025 Dr-MorchCrafts. Designed with flair, coded with care.

    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/js/splide.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($products as $index => $product)
        new Splide('#splide-{{ $index }}', {
            type: 'loop',
            perPage: 1,
            height: '13rem',
            arrows: true,
            pagination: true,
            autoplay: false,
        }).mount();
        @endforeach
    });
</script>
</body>
</html>
