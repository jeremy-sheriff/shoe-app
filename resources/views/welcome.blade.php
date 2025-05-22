<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dr-MorchCrafts - Custom Shoe Design</title>

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
</head>

@vite('resources/js/app.js')
@vite('resources/css/app.css')
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

<!-- Hero Section -->
<section class="hero bg-gradient-to-br from-primary to-secondary text-black px-6 md:px-20">
    <div class="flex flex-col md:flex-row items-center gap-12">
        <div class="hero-content text-center md:text-left md:w-1/2 w-full">
            <h1 class="text-6xl font-extrabold leading-tight mb-6">
                Design Your Dream <span class="text-accent">Shoe</span>
            </h1>
            <p class="text-lg mb-8">
                Crafts personalized footwear that speaks your vibe, built with top-tier materials and unmatched care.
            </p>

            <div class="flex justify-center md:justify-start gap-4 mb-6 flex-wrap">
                <a href="#" class="px-6 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600 transition">Start
                    Designing</a>
                <a href="#"
                   class="px-6 py-2 border border-black text-black font-semibold rounded hover:bg-black hover:text-white transition">View
                    Gallery</a>
            </div>


            <!-- Full Width Order Tracking Form -->
            <form method="GET" action="{{ route('orders.track') }}" class="w-full">
                <div class="flex flex-col sm:flex-row gap-2 items-stretch w-full max-w-full">
                    <input
                        type="text"
                        name="tracking_number"
                        placeholder="Enter your tracking number"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-black"
                        required
                    >
                    <button
                        type="submit"
                        class="px-6 py-3 bg-black text-white font-medium rounded-md shadow hover:bg-gray-900 transition w-full sm:w-auto"
                    >
                        Track Order
                    </button>
                </div>
            </form>

            @if($errors->any())
                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <strong class="font-bold">Please fix the following errors:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            @if(session('order'))
                @php
                    $order = session('order');
                @endphp

                    <!-- Order Summary Card -->
                <div class="bg-white shadow-lg rounded-2xl p-6 mt-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Order Summary</h2>

                    <div class="space-y-2 text-sm text-gray-700">
                        <p><span class="font-semibold">Tracking Number:</span> {{ $order['tracking_number'] }}</p>
                        <p><span class="font-semibold">Customer Name:</span> {{ $order['customer_name'] }}</p>
                        <p><span class="font-semibold">To be delivered to:</span> {{ $order['town'] }}</p>
                        <p><span class="font-semibold">MPESA Number:</span> {{ $order['mpesa_number'] }}</p>
                        <p><span class="font-semibold">Amount:</span> KES {{ $order['amount'] }}</p>
                        <p><span class="font-semibold">Payment Status:</span> {{ ucfirst($order['payment_status']) }}
                        </p>
                        <p><span class="font-semibold">Order Status:</span> {{ ucfirst($order['status']) }}</p>
                        <p><span
                                class="font-semibold">Created At:</span> {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y, h:i A') }}
                        </p>
                    </div>
                </div>
            @endif

        </div>

        <div class="hero-image md:w-1/2 w-full py-6">
            <img height="400px" width="600px"
                 src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28?auto=format&fit=crop&w=800&q=80"
                 alt="Custom Shoes" class="rounded-3xl shadow-2xl w-full max-w-lg mx-auto">
        </div>
    </div>
</section>


<!-- Wavy Divider -->
<div class="relative z-0">
    <svg class="block w-full" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path fill="var(--secondary)"
              d="M0,160L80,165.3C160,171,320,181,480,170.7C640,160,800,128,960,122.7C1120,117,1280,139,1360,149.3L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"/>
    </svg>
</div>


<!-- Features Section -->
<section class="py-24 px-6 md:px-20" style="background-color: var(--secondary); color: var(--dark);">
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


<!-- Shopping Section -->
<section class=" dark:bg-zinc-900 py-24 px-6 md:px-20">
    <div class="text-center mb-16">
        <h2 class="text-5xl font-bold mb-4 text-zinc-800 dark:text-white">Shop Custom Shoes</h2>
        <p class="max-w-2xl mx-auto text-zinc-600 dark:text-zinc-300">
            Browse our collection of unique, handcrafted shoes created by our talented community of designers.
        </p>
    </div>

    <div class="grid gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @foreach ($products as $index => $product)
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl shadow hover:shadow-lg transition">
                {{-- Splide Carousel --}}
                @if($product->images->count())
                    <div id="splide-{{ $index }}" class="splide mb-4">
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
                <h3 class="text-xl font-semibold text-zinc-800 dark:text-white mb-2">{{ $product->name }}</h3>
                <p class="text-zinc-600 dark:text-zinc-300 text-sm mb-4">{{ $product->description }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-lg font-bold text-primary">KSh {{ number_format($product->price, 2) }}</span>
                    <a href="{{ route('item.show', $product->slug) }}" class="btn btn-outline text-sm">View</a>
                </div>
            </div>
        @endforeach
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
            height: '14rem',
            arrows: true,
            pagination: true,
            autoplay: true,
        }).mount();
        @endforeach
    });
</script>
</body>
</html>
