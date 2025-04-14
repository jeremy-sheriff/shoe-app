<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SoleCraft - Custom Shoe Design</title>

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
            --dark: #292F36;
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
        <span class="text-primary">Sole</span><span class="text-secondary">Craft</span>
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
<section class="hero bg-gradient-to-br from-primary to-secondary text-white py-20 px-6 md:px-12">
    <div class="flex flex-col md:flex-row items-center gap-12">
        <div class="hero-content text-center md:text-left md:w-1/2">
            <h1 class="text-5xl font-bold leading-tight mb-6">Design Your Dream <span class="text-accent">Shoes</span></h1>
            <p class="text-lg mb-8">Create custom footwear that reflects your unique personality and style.</p>
            <div class="flex justify-center md:justify-start gap-4">
                <a href="#" class="btn btn-primary">Start Designing</a>
                <a href="#" class="btn btn-outline">Browse Designs</a>
            </div>
        </div>
        <div class="hero-image md:w-1/2">
            <img src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28?auto=format&fit=crop&w=800&q=80" alt="Custom Shoes" class="rounded-3xl shadow-xl">
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 px-6 md:px-12 bg-gray-50">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold mb-4">Why Choose SoleCraft?</h2>
        <p class="max-w-xl mx-auto">Everything you need to craft your perfect pair of shoes, all in one place.</p>
    </div>
    <div class="grid gap-8 md:grid-cols-3">
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
            <div class="text-5xl mb-4 text-primary text-center">🎨</div>
            <h3 class="text-xl font-bold mb-2 text-center">Easy Design Tool</h3>
            <p class="text-center">Intuitive drag-and-drop designer for everyone—no skills needed.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
            <div class="text-5xl mb-4 text-secondary text-center">👟</div>
            <h3 class="text-xl font-bold mb-2 text-center">Premium Materials</h3>
            <p class="text-center">Top-tier materials for durability, comfort, and unbeatable style.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
            <div class="text-5xl mb-4 text-primary text-center">🚀</div>
            <h3 class="text-xl font-bold mb-2 text-center">Fast Production</h3>
            <p class="text-center">Quick turnaround: get your custom pair in as little as 2 weeks.</p>
        </div>
    </div>
</section>

<!-- Call To Action -->
<section class="bg-dark text-white py-20 text-center">
    <h2 class="text-3xl md:text-4xl font-bold mb-6">Join the Movement in Custom Shoe Design</h2>
    <p class="mb-8">Whether you're a fashionista or sneakerhead, SoleCraft has you covered.</p>
    <a href="#" class="btn btn-primary">Create Your First Pair</a>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12 px-6 md:px-12">
    <div class="grid md:grid-cols-4 gap-8">
        <div>
            <h3 class="text-xl font-bold mb-4 text-primary">SoleCraft</h3>
            <p>Custom shoes made easy, accessible, and personal.</p>
        </div>
        <div>
            <h4 class="font-bold mb-2">Explore</h4>
            <ul class="space-y-1">
                <li><a href="#" class="hover:text-primary">About</a></li>
                <li><a href="#" class="hover:text-primary">Blog</a></li>
                <li><a href="#" class="hover:text-primary">Design Gallery</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold mb-2">Support</h4>
            <ul class="space-y-1">
                <li><a href="#" class="hover:text-primary">FAQs</a></li>
                <li><a href="#" class="hover:text-primary">Contact</a></li>
                <li><a href="#" class="hover:text-primary">Returns</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold mb-2">Follow Us</h4>
            <div class="flex gap-4 text-xl">
                <a href="#" class="hover:text-primary"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-primary"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-primary"><i class="fab fa-facebook"></i></a>
            </div>
        </div>
    </div>
    <div class="text-center text-sm mt-12 border-t pt-6 border-gray-700">
        &copy; 2025 SoleCraft. All rights reserved.
    </div>
</footer>
</body>
</html>
