<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SoleCraft - Custom Shoe Design</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            margin: 0;
            padding: 0;
        }

        .bg-primary {
            background-color: var(--primary);
        }

        .bg-secondary {
            background-color: var(--secondary);
        }

        .text-primary {
            color: var(--primary);
        }

        .text-secondary {
            color: var(--secondary);
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
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

        .hero {
            min-height: 80vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            max-width: 600px;
            z-index: 2;
        }

        .hero-image {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 50%;
            max-width: 600px;
            z-index: 1;
        }

        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .shoe-display {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }

        .shoe-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .shoe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .shoe-img {
            height: 200px;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        .designer-tool {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 16px;
            padding: 60px;
            color: white;
        }

        footer {
            background-color: var(--dark);
            color: white;
            padding: 60px 0;
        }

        @media (max-width: 768px) {
            .hero {
                min-height: auto;
                padding: 60px 0;
            }

            .hero-content {
                max-width: 100%;
                text-align: center;
            }

            .hero-image {
                position: relative;
                width: 100%;
                transform: none;
                margin-top: 40px;
            }
        }
    </style>
</head>
<body>
<!-- Navigation -->
<nav class="py-6 px-4 md:px-12 flex justify-between items-center">
    <div class="text-2xl font-bold">
        <span class="text-primary">Sole</span><span class="text-secondary">Craft</span>
    </div>

    @if (Route::has('login'))
        <div class="flex items-center space-x-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-outline">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-dark hover:text-primary">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endif
            @endauth
        </div>
    @endif
</nav>

<!-- Hero Section -->
<section class="hero px-4 md:px-12">
    <div class="hero-content">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">Design Your Dream <span class="text-primary">Shoes</span></h1>
        <p class="text-lg mb-8">Create custom footwear that matches your unique style. Our platform makes shoe design easy and fun!</p>
        <div class="flex space-x-4">
            <a href="#" class="btn btn-primary">Start Designing</a>
            <a href="#" class="btn btn-outline">Browse Designs</a>
        </div>
    </div>
    <div class="hero-image">
        <img src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Custom Shoes" class="w-full h-auto">
    </div>
</section>

<!-- Features Section -->
<section class="py-20 px-4 md:px-12">
    <div class="text-center mb-16">
        <h2 class="text-3xl font-bold mb-4">Why Choose SoleCraft?</h2>
        <p class="max-w-2xl mx-auto">We provide everything you need to create the perfect custom shoes</p>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        <div class="feature-card">
            <div class="text-4xl mb-4 text-primary">🎨</div>
            <h3 class="text-xl font-bold mb-2">Easy Design Tool</h3>
            <p>Our intuitive designer makes it simple to create unique shoe designs with no experience needed.</p>
        </div>

        <div class="feature-card">
            <div class="text-4xl mb-4 text-secondary">👟</div>
            <h3 class="text-xl font-bold mb-2">Premium Materials</h3>
            <p>We use only the highest quality materials to ensure your custom shoes look and feel amazing.</p>
        </div>

        <div class="feature-card">
            <div class="text-4xl mb-4 text-primary">🚀</div>
            <h3 class="text-xl font-bold mb-2">Fast Production</h3>
            <p>Get your custom shoes in 2-3 weeks with our streamlined manufacturing process.</p>
        </div>
    </div>
</section>

<!-- Popular Designs -->
<section class="py-20 px-4 md:px-12 bg-gray-50">
    <div class="text-center mb-16">
        <h2 class="text-3xl font-bold mb-4">Popular Designs</h2>
        <p class="max-w-2xl mx-auto">Get inspired by our community's creations</p>
    </div>

    <div class="shoe-display">
        <div class="shoe-card">
            <div class="shoe-img" style="background-image: url('https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80')"></div>
            <div class="p-4">
                <h3 class="font-bold">Urban Explorer</h3>
                <p class="text-sm text-gray-600">by @shoelover22</p>
            </div>
        </div>

        <div class="shoe-card">
            <div class="shoe-img" style="background-image: url('https://images.unsplash.com/photo-1600269452121-4f2416e55c28?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80')"></div>
            <div class="p-4">
                <h3 class="font-bold">Neon Dreams</h3>
                <p class="text-sm text-gray-600">by @designpro</p>
            </div>
        </div>

        <div class="shoe-card">
            <div class="shoe-img" style="background-image: url('https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80')"></div>
            <div class="p-4">
                <h3 class="font-bold">Classic Retro</h3>
                <p class="text-sm text-gray-600">by @vintagesole</p>
            </div>
        </div>

        <div class="shoe-card">
            <div class="shoe-img" style="background-image: url('https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80')"></div>
            <div class="p-4">
                <h3 class="font-bold">Sport Luxe</h3>
                <p class="text-sm text-gray-600">by @athletichype</p>
            </div>
        </div>
    </div>

    <div class="text-center mt-12">
        <a href="#" class="btn btn-outline">View All Designs</a>
    </div>
</section>

<!-- Designer Tool -->
<section class="py-20 px-4 md:px-12">
    <div class="designer-tool">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-6">Try Our Designer Tool</h2>
            <p class="mb-8">Experience how easy it is to create your perfect shoe design with our interactive tool.</p>
            <a href="#" class="btn bg-white text-dark hover:bg-gray-100">Launch Designer</a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-20 px-4 md:px-12 bg-gray-50">
    <div class="text-center mb-16">
        <h2 class="text-3xl font-bold mb-4">What Our Customers Say</h2>
    </div>

    <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <div class="bg-white p-8 rounded-lg shadow-sm">
            <div class="text-yellow-400 mb-4">★★★★★</div>
            <p class="mb-4">"I designed my wedding shoes with SoleCraft and they were absolutely perfect! The quality exceeded my expectations."</p>
            <div class="font-bold">- Sarah J.</div>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-sm">
            <div class="text-yellow-400 mb-4">★★★★★</div>
            <p class="mb-4">"As a sneakerhead, I love being able to create truly unique designs. The customization options are endless!"</p>
            <div class="font-bold">- Marcus T.</div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 px-4 md:px-12 bg-primary text-white">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-6">Ready to Design Your Perfect Shoes?</h2>
        <p class="mb-8">Join thousands of happy customers who've created their dream footwear with SoleCraft.</p>
        <a href="#" class="btn bg-white text-primary hover:bg-gray-100">Get Started Now</a>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container mx-auto px-4 md:px-12">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <div class="text-2xl font-bold mb-4">
                    <span class="text-primary">Sole</span><span class="text-secondary">Craft</span>
                </div>
                <p>Making custom shoe design accessible to everyone.</p>
            </div>

            <div>
                <h3 class="font-bold mb-4">Company</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-primary">About Us</a></li>
                    <li><a href="#" class="hover:text-primary">Careers</a></li>
                    <li><a href="#" class="hover:text-primary">Blog</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold mb-4">Support</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-primary">FAQ</a></li>
                    <li><a href="#" class="hover:text-primary">Contact Us</a></li>
                    <li><a href="#" class="hover:text-primary">Shipping Info</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold mb-4">Connect</h3>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-primary">Instagram</a>
                    <a href="#" class="hover:text-primary">Twitter</a>
                    <a href="#" class="hover:text-primary">Facebook</a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-12 pt-8 text-center text-sm">
            <p>© 2023 SoleCraft. All rights reserved.</p>
        </div>
    </div>
</footer>
</body>
</html>
