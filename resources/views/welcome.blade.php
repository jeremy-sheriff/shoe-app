<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dr-MorchCrafts - Custom Shoe Design</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Tailwind CDN for utility classes -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #FF6B6B;
            --secondary: #4ECDC4;
            --dark: #1a1a1a;
            --light: #F7FFF7;
            --accent: #FFE66D;
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
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endif
            @endauth
        </div>
    @endif
</nav>

<!-- Hero Section -->
<section class="hero bg-gradient-to-br from-primary to-secondary text-black py-24 px-6 md:px-20">
    <div class="flex flex-col md:flex-row items-center gap-12">
        <div class="hero-content text-center md:text-left md:w-1/2">
            <h1 class="text-6xl font-extrabold leading-tight mb-6">Design Your Dream <span
                    class="text-accent">Shoes</span></h1>
            <p class="text-lg mb-8">Craft personalized footwear that speaks your vibe, built with top-tier materials and
                unmatched care.</p>
            <div class="flex justify-center md:justify-start gap-4">
                <a href="#" class="btn btn-primary">Start Designing</a>
                <a href="#" class="btn btn-outline">View Gallery</a>
            </div>
        </div>
        <div class="hero-image md:w-1/2">
            <img src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28?auto=format&fit=crop&w=800&q=80"
                 alt="Custom Shoes" class="rounded-3xl shadow-2xl">
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-24 px-6 md:px-20 bg-gray-50">
    <div class="text-center mb-16">
        <h2 class="text-5xl font-bold mb-4">Why Choose Dr-MorchCrafts?</h2>
        <p class="max-w-2xl mx-auto">Seamless experience from design to doorstep — quality, creativity, and quick
            delivery in one place.</p>
    </div>
    <div class="grid gap-10 md:grid-cols-3">
        <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition">
            <div class="text-5xl mb-4 text-primary text-center">🎨</div>
            <h3 class="text-2xl font-bold mb-3 text-center">Easy Design Tool</h3>
            <p class="text-center">Visual drag-and-drop designer tailored for your imagination. No experience
                required.</p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition">
            <div class="text-5xl mb-4 text-secondary text-center">👟</div>
            <h3 class="text-2xl font-bold mb-3 text-center">Premium Materials</h3>
            <p class="text-center">Only the finest — comfort, durability, and elegance in every pair we craft.</p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition">
            <div class="text-5xl mb-4 text-primary text-center">🚀</div>
            <h3 class="text-2xl font-bold mb-3 text-center">Fast Production</h3>
            <p class="text-center">Your custom shoes, crafted and delivered in record time — as fast as 14 days!</p>
        </div>
    </div>
</section>

<!-- Call To Action -->
<section class="bg-dark text-white py-24 text-center">
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
</body>
</html>
