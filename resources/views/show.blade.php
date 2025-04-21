<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

                <div class="flex items-center gap-4">
                    <label for="color" class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Color:</label>
                    <select name="color" id="color"
                            class="px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                        <option value="">Select Color</option>
                        <option value="black">Black</option>
                        <option value="white">White</option>
                        <option value="red">Red</option>
                        <option value="blue">Blue</option>
                        <option value="custom">Custom Mix</option>
                    </select>
                </div>
                <button type="submit"
                        class="mt-4 inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow-md transition duration-150">
                    <i class="fa fa-cart-plus mr-2"></i> Add to Cart
                </button>
            </form>
        </div>
    </div>

    {{-- Cart Items Table --}}
    @php
        $cart = session('cart', []);
        $cartTotal = 0;
    @endphp

    @if(count($cart))
        <div class="mt-16 max-w-5xl mx-auto">
            <h2 class="text-2xl font-bold mb-4 text-zinc-800 dark:text-white">Your Cart</h2>
            <table
                class="w-full text-left border border-zinc-200 dark:border-zinc-700 shadow rounded-xl overflow-hidden">
                <thead class="bg-zinc-100 dark:bg-zinc-800 text-sm uppercase">
                <tr>
                    <th class="p-3">Image</th>
                    <th class="p-3">Product</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Add/Reduce</th>
                    <th class="p-3">Color</th>
                    <th class="p-3">Qty</th>
                    <th class="p-3">Subtotal</th>
                    <th class="p-3">Action</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach($cart as $id => $item)
                    @php
                        $subtotal = $item['price'] * $item['quantity'];
                        $cartTotal += $subtotal;
                    @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <td class="p-3">
                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-16 h-16 object-cover rounded"
                                 alt="{{ $item['name'] }}">
                        </td>
                        <td class="p-3 font-medium">{{ $item['name'] }}</td>
                        <td class="p-3">KSh {{ number_format($item['price'], 2) }}</td>
                        <td class="p-3">
                            <div class="flex items-center gap-2">
                                <form action="{{ route('cart.decrease', $id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-2 py-1 bg-gray-200 dark:bg-zinc-700 rounded">-
                                    </button>
                                </form>
                                <span>{{ $item['quantity'] }}</span>
                                <form action="{{ route('cart.increase', $id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-2 py-1 bg-gray-200 dark:bg-zinc-700 rounded">+
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td class="p-3">KSh {{ number_format($item['price'], 2) }}</td>
                        <td class="p-3 capitalize">{{ $item['color'] ?? 'N/A' }}</td>
                        <td class="p-3 font-semibold">KSh {{ number_format($subtotal, 2) }}</td>
                        <td class="p-3">
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 hover:underline text-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr class="bg-zinc-100 dark:bg-zinc-800 font-bold">
                    <td colspan="6" class="p-3 text-right">Total</td>
                    <td class="p-3">KSh {{ number_format($cartTotal, 2) }}</td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    @endif
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
