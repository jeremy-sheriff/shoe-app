<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/css/splide.min.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white min-h-screen">

<section class="py-4 md:py-16 px-4 md:px-6 lg:px-20">
    <div class="max-w-7xl mx-auto">
        <!-- Mobile Layout: Stack everything vertically -->
        <div class="block lg:hidden space-y-6">
            <!-- Mobile Product Image -->
            <div class="w-full">
                @if($product->images->count())
                    <div id="product-carousel-mobile" class="splide">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach($product->images as $image)
                                    <li class="splide__slide">
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}"
                                             class="rounded-xl object-cover w-full h-[280px] sm:h-[350px] shadow"/>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @else
                    <div
                        class="bg-zinc-300 dark:bg-zinc-700 h-[280px] sm:h-[350px] rounded-lg flex items-center justify-center">
                        <span class="text-zinc-600 dark:text-zinc-200">No Image Available</span>
                    </div>
                @endif
            </div>

            <!-- Mobile Product Info -->
            <div class="px-2">
                <h1 class="text-2xl sm:text-3xl font-bold text-zinc-800 dark:text-white mb-2">{{ $product->name }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-300 mb-2">
                    Category: {{ $product->category->name ?? 'Uncategorized' }}
                </p>
                <p class="text-base text-zinc-700 dark:text-zinc-300 leading-relaxed mb-4">{{ $product->description }}</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-indigo-600 mb-4">
                    KSh {{ number_format($product->price, 2) }}
                </p>
            </div>

            <!-- Mobile Add to Cart Form -->
            <div class="bg-white dark:bg-zinc-800 p-4 rounded-xl shadow">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="quantity-mobile"
                                   class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">
                                Quantity
                            </label>
                            <input type="number" name="quantity" id="quantity-mobile" min="1" value="1"
                                   class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                        </div>

                        <div>
                            <label for="color-mobile"
                                   class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">
                                Color
                            </label>
                            <select name="color" id="color-mobile"
                                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                                <option value="">Select Color</option>
                                @if (!empty($product->colors) && is_array($product->colors))
                                    @foreach ($product->colors as $color)
                                        <option value="{{ strtolower($color) }}">{{ ucfirst($color) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="sizes-mobile"
                               class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">
                            Size
                        </label>
                        <select name="sizes" id="sizes-mobile" required
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                            <option value="">Select a size</option>
                            @foreach ($product->sizes as $size)
                                <option
                                    value="{{ $size }}" {{ old('sizes') == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit"
                                class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow-md transition duration-150">
                            <i class="fa fa-cart-plus mr-2"></i> Add to Cart
                        </button>
                        <a href="{{ route('home') }}"
                           class="flex-1 inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-gray-700 hover:bg-gray-800 rounded-md transition">
                            ← Continue Shopping
                        </a>
                    </div>
                </form>
            </div>

            <!-- Mobile Checkout Form -->
            @php
                $cart = session('cart', []);
                $cartTotal = 0;
                foreach($cart as $item) {
                    $cartTotal += $item['price'] * $item['quantity'];
                }
            @endphp

            @if(count($cart))
                <div class="bg-white dark:bg-zinc-800 p-4 rounded-xl shadow">
                    <h2 class="text-xl font-bold mb-4 text-zinc-800 dark:text-white">Checkout</h2>
                    <form action="{{ route('checkout.confirm') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="mpesa_number-mobile"
                                   class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                M-Pesa Number
                            </label>
                            <input type="text" name="mpesa_number" id="mpesa_number-mobile" required
                                   placeholder="e.g. 0712345678"
                                   class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white">

                            <div class="mt-2 flex items-start gap-2">
                                <input type="checkbox" name="use_as_contact" id="use_as_contact-mobile"
                                       class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <label for="use_as_contact-mobile" class="text-sm text-zinc-700 dark:text-zinc-300">
                                    <i>Use this number as my contact number</i>
                                </label>
                            </div>
                            <input name="product" value="{{$product->id}}" hidden>
                        </div>

                        <div>
                            <label for="customer_name-mobile"
                                   class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Full Names
                            </label>
                            <input type="text" name="customer_name" id="customer_name-mobile" required
                                   placeholder="e.g. John Doe"
                                   class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white">
                        </div>

                        <div>
                            <label for="town-mobile"
                                   class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Town
                            </label>
                            <input type="text" name="town" id="town-mobile" required placeholder="e.g. Westlands"
                                   class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white">
                        </div>

                        <div>
                            <label for="description-mobile"
                                   class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Description
                            </label>
                            <textarea name="description" id="description-mobile" rows="3" required
                                      class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white">
                            </textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                    class="w-full px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow-md transition duration-150">
                                Confirm Order (KSh {{ number_format($cartTotal, 2) }})
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <!-- Desktop Layout: Original grid layout -->
        <div class="hidden lg:grid lg:grid-cols-10 gap-8">
            <!-- Left: Product Carousel + Add to Cart Form + Cart -->
            <div class="lg:col-span-7 space-y-12">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Product Image Carousel -->
                    <div>
                        @if($product->images->count())
                            <div id="product-carousel" class="splide">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        @foreach($product->images as $image)
                                            <li class="splide__slide">
                                                <img src="{{ asset('storage/' . $image->path) }}"
                                                     alt="{{ $product->name }}"
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

                    <!-- Add to Cart Form -->
                    <div>
                        <h1 class="text-4xl font-bold text-zinc-800 dark:text-white mb-4">{{ $product->name }}</h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-300 mb-2">
                            Category: {{ $product->category->name ?? 'Uncategorized' }}</p>
                        <p class="text-lg text-zinc-700 dark:text-zinc-300 leading-relaxed mb-6">{{ $product->description }}</p>
                        <p class="text-3xl font-extrabold text-indigo-600 mb-8">
                            KSh {{ number_format($product->price, 2) }}</p>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex items-center gap-4">
                                <label for="quantity"
                                       class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Quantity:</label>
                                <input type="number" name="quantity" id="quantity" min="1" value="1"
                                       class="w-20 px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                            </div>

                            <div class="flex items-center gap-4">
                                <label for="color"
                                       class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Color:</label>

                                <select name="color" id="color"
                                        class="px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                                    <option value="">Select Color</option>
                                    @if (!empty($product->colors) && is_array($product->colors))
                                        @foreach ($product->colors as $color)
                                            <option value="{{ strtolower($color) }}">{{ ucfirst($color) }}</option>
                                        @endforeach
                                    @endif
                                </select>

                                <div class="form-group">
                                    <select name="sizes" id="sizes"
                                            class="px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white"
                                            required>
                                        <option value="">Select a size</option>
                                        @foreach ($product->sizes as $size)
                                            <option
                                                value="{{ $size }}" {{ old('sizes') == $size ? 'selected' : '' }}>{{ $size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4 flex flex-wrap items-center gap-4">
                                <button type="submit"
                                        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow-md transition duration-150">
                                    <i class="fa fa-cart-plus mr-2"></i> Add to Cart
                                </button>

                                <a href="{{ route('home') }}"
                                   class="inline-block px-6 py-3 text-sm font-semibold text-white bg-gray-700 hover:bg-gray-800 rounded-md transition">
                                    ← Continue Shopping
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Cart Table -->
                @php
                    $cart = session('cart', []);
                    $cartTotal = 0;
                @endphp

                <div>
                    <h2 class="text-2xl font-bold mb-4 text-zinc-800 dark:text-white">Your Cart</h2>
                    <div class="overflow-x-auto">
                        <table
                            class="w-full text-left border border-zinc-200 dark:border-zinc-700 shadow rounded-xl overflow-hidden">
                            <thead class="bg-zinc-100 dark:bg-zinc-800 text-sm uppercase">
                            <tr>
                                <th class="p-3">Image</th>
                                <th class="p-3">Product</th>
                                <th class="p-3">Price</th>
                                <th class="p-3">Color</th>
                                <th class="p-3">Qty</th>
                                <th class="p-3">Subtotal</th>
                                <th class="p-3">Action</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($cart as $id => $item)
                                @php $subtotal = $item['price'] * $item['quantity']; $cartTotal += $subtotal; @endphp
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                    <td class="p-3">
                                        <img src="{{ asset('storage/' . $item['image']) }}"
                                             class="w-16 h-16 object-cover rounded" alt="{{ $item['name'] }}">
                                    </td>
                                    <td class="p-3 font-medium">{{ $item['name'] }}</td>
                                    <td class="p-3">KSh {{ number_format($item['price'], 2) }}</td>
                                    <td class="p-3 capitalize">{{ $item['color'] ?? 'N/A' }}</td>
                                    <td class="p-3">
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('cart.decrease', $id) }}" method="POST"
                                                  class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                        class="px-2 py-1 bg-gray-200 dark:bg-zinc-700 rounded">-
                                                </button>
                                            </form>
                                            <span>{{ $item['quantity'] }}</span>
                                            <form action="{{ route('cart.increase', $id) }}" method="POST"
                                                  class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                        class="px-2 py-1 bg-gray-200 dark:bg-zinc-700 rounded">+
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="p-3 font-semibold">KSh {{ number_format($subtotal, 2) }}</td>
                                    <td class="p-3">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:underline text-sm">Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-zinc-500 dark:text-zinc-400">Your cart
                                        is empty.
                                    </td>
                                </tr>
                            @endforelse

                            @if(count($cart))
                                <tr class="bg-zinc-100 dark:bg-zinc-800 font-bold">
                                    <td colspan="5" class="p-3 text-right">Total</td>
                                    <td class="p-3">KSh {{ number_format($cartTotal, 2) }}</td>
                                    <td></td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                @if(session('trackingNumber'))
                    <div class="bg-white dark:bg-zinc-800 p-4 shadow rounded mb-4">
                        <h2 class="text-lg font-bold">Order Details</h2>
                        <div class="flex items-center space-x-2">
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>Tracking Number:</strong>
                                <span id="trackingNumber">{{ session('trackingNumber') }}</span>
                            </p>
                            <button onclick="copyTrackingNumber()" title="Copy"
                                    class="text-gray-600 hover:text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-4 12h4a2 2 0 002-2v-8a2 2 0 00-2-2h-4a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                        <p class="text-sm text-yellow-500 mt-2">
                            ⚠️ This tracking number will be shown <strong>only once</strong>. It will disappear if you
                            refresh or navigate away from this page.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Right: Checkout Form -->
            <div class="lg:col-span-3 bg-white dark:bg-zinc-800 p-6 rounded-xl shadow h-fit">
                <livewire:checkouts.checkout-component :cart="$cart" :product="$product" :cartTotal="$cartTotal"/>
            </div>
        </div>

        <!-- Mobile Cart Table -->
        <div class="block lg:hidden mt-6">
            <h2 class="text-xl font-bold mb-4 text-zinc-800 dark:text-white">Your Cart</h2>
            @if(count($cart))
                <div class="space-y-4">
                    @foreach($cart as $id => $item)
                        @php $subtotal = $item['price'] * $item['quantity']; @endphp
                        <div class="bg-white dark:bg-zinc-800 rounded-lg p-4 shadow">
                            <div class="flex items-start space-x-4">
                                <img src="{{ asset('storage/' . $item['image']) }}"
                                     class="w-16 h-16 object-cover rounded" alt="{{ $item['name'] }}">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-zinc-900 dark:text-white truncate">{{ $item['name'] }}</h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                        KSh {{ number_format($item['price'], 2) }}
                                        @if($item['color'])
                                            • {{ ucfirst($item['color']) }}
                                        @endif
                                    </p>
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="flex items-center space-x-2">
                                            <form action="{{ route('cart.decrease', $id) }}" method="POST"
                                                  class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                        class="w-8 h-8 bg-gray-200 dark:bg-zinc-700 rounded-full flex items-center justify-center text-sm">
                                                    -
                                                </button>
                                            </form>
                                            <span
                                                class="px-2 py-1 bg-gray-100 dark:bg-zinc-700 rounded text-sm">{{ $item['quantity'] }}</span>
                                            <form action="{{ route('cart.increase', $id) }}" method="POST"
                                                  class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                        class="w-8 h-8 bg-gray-200 dark:bg-zinc-700 rounded-full flex items-center justify-center text-sm">
                                                    +
                                                </button>
                                            </form>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-zinc-900 dark:text-white">
                                                KSh {{ number_format($subtotal, 2) }}</p>
                                            <form action="{{ route('cart.remove', $id) }}" method="POST"
                                                  class="inline-block">
                                                @csrf
                                                <button type="submit" class="text-red-500 hover:underline text-sm">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="bg-zinc-100 dark:bg-zinc-800 rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-zinc-900 dark:text-white">Total</span>
                            <span
                                class="text-lg font-bold text-zinc-900 dark:text-white">KSh {{ number_format($cartTotal, 2) }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 text-center">
                    <p class="text-zinc-500 dark:text-zinc-400">Your cart is empty.</p>
                </div>
            @endif
        </div>

        <!-- Mobile Tracking Number -->
        @if(session('trackingNumber'))
            <div class="block lg:hidden mt-6 bg-white dark:bg-zinc-800 p-4 shadow rounded">
                <h2 class="text-lg font-bold mb-2">Order Details</h2>
                <div class="flex items-center space-x-2">
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        <strong>Tracking Number:</strong>
                        <span id="trackingNumberMobile">{{ session('trackingNumber') }}</span>
                    </p>
                    <button onclick="copyTrackingNumberMobile()" title="Copy" class="text-gray-600 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-4 12h4a2 2 0 002-2v-8a2 2 0 00-2-2h-4a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-yellow-500 mt-2">
                    ⚠️ This tracking number will be shown <strong>only once</strong>. It will disappear if you refresh
                    or navigate away from this page.
                </p>
            </div>

            <script>
                function copyTrackingNumberMobile() {
                    const text = document.getElementById('trackingNumberMobile').innerText;
                    navigator.clipboard.writeText(text).then(() => {
                        alert("Tracking number copied to clipboard!");
                    }).catch(err => {
                        alert("Failed to copy. Try manually.");
                    });
                }
            </script>
        @endif
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/js/splide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Desktop carousel
        if (document.getElementById('product-carousel')) {
            new Splide('#product-carousel', {
                type: 'loop',
                perPage: 1,
                pagination: true,
                arrows: true,
                height: '400px'
            }).mount();
        }

        // Mobile carousel
        if (document.getElementById('product-carousel-mobile')) {
            new Splide('#product-carousel-mobile', {
                type: 'loop',
                perPage: 1,
                pagination: true,
                arrows: true,
                height: '280px',
                breakpoints: {
                    640: {
                        height: '350px'
                    }
                }
            }).mount();
        }
    });

    function copyTrackingNumber() {
        const text = document.getElementById('trackingNumber').innerText;
        navigator.clipboard.writeText(text).then(() => {
            alert("Tracking number copied to clipboard!");
        }).catch(err => {
            alert("Failed to copy. Try manually.");
        });
    }
</script>

@fluxScripts
</body>
</html>
