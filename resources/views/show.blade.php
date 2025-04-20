<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Splide Carousel CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/css/splide.min.css"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white min-h-screen">

<section class="py-16 px-6 md:px-20">
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12">

        {{-- Product Image Carousel --}}
        <div>
            @if($product->images->count())
                <div id="product-carousel" class="splide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach($product->images as $image)
                                <li class="splide__slide">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}"
                                         class="rounded-xl object-cover w-full h-[400px] shadow"/>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <div class="bg-zinc-300 dark:bg-zinc-700 h-96 rounded-lg flex items-center justify-center">
                    <span class="text-zinc-600 dark:text-zinc-200">No Image Available</span>
                </div>
            @endif
        </div>

        {{-- Product Details --}}
        <div>
            <h1 class="text-4xl font-bold text-zinc-800 dark:text-white mb-4">{{ $product->name }}</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-300 mb-2">
                Category: {{ $product->category->name ?? 'Uncategorized' }}</p>
            <p class="text-lg text-zinc-700 dark:text-zinc-300 leading-relaxed mb-6">{{ $product->description }}</p>
            <p class="text-3xl font-extrabold text-indigo-600 mb-8">KSh {{ number_format($product->price, 2) }}</p>

            {{-- Add to Cart Form --}}
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex items-center gap-4">
                    <label for="quantity" class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" min="1" value="1"
                           class="w-20 px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                </div>
                <button type="submit"
                        class="mt-4 inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow-md transition duration-150">
                    <i class="fa fa-cart-plus mr-2"></i> Add to Cart
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Splide Carousel JS -->
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/js/splide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Splide('#product-carousel', {
            type: 'loop',
            perPage: 1,
            pagination: true,
            arrows: true,
            height: '400px'
        }).mount();
    });
</script>

@fluxScripts
</body>
</html>
