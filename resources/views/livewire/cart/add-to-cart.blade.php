<div>
    <!-- Desktop Form -->
    <div class="hidden md:block">
        <form wire:submit.prevent="addToCart" class="space-y-4">
            <!-- Quantity -->
            <div class="flex items-center gap-4">
                <label for="quantity" class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Quantity:</label>
                <input
                    type="number"
                    wire:model="quantity"
                    id="quantity"
                    min="1"
                    class="w-20 px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white"
                >
                @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Color and Size -->
            <div class="flex items-center gap-4">
                <label for="color" class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Color:</label>
                <select
                    wire:model="selectedColor"
                    id="color"
                    class="px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white"
                >
                    <option value="">Select Color</option>
                    @if (!empty($product->colors) && is_array($product->colors))
                        @foreach ($product->colors as $color)
                            <option value="{{ strtolower($color) }}">{{ ucfirst($color) }}</option>
                        @endforeach
                    @endif
                </select>

                <select
                    wire:model="selectedSize"
                    id="sizes"
                    class="px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white"
                    required
                >
                    <option value="">Select a size</option>
                    @foreach ($product->sizes as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
                @error('selectedSize') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Buttons -->
            <div class="mt-4 flex flex-wrap items-center gap-4">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-400 text-white font-semibold rounded-md shadow-md transition duration-150"
                >
                    <span wire:loading.remove>
                        <i class="fa fa-cart-plus mr-2"></i> Add to Cart
                    </span>
                    <span wire:loading>
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Adding...
                    </span>
                </button>

                <a href="{{ route('home') }}"
                   class="inline-block px-6 py-3 text-sm font-semibold text-white bg-gray-700 hover:bg-gray-800 rounded-md transition">
                    ← Continue Shopping
                </a>
            </div>
        </form>
    </div>

    <!-- Mobile Form -->
    <div class="block md:hidden bg-white dark:bg-zinc-800 p-4 rounded-xl shadow">
        <form wire:submit.prevent="addToCart" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Quantity -->
                <div>
                    <label for="quantity-mobile"
                           class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">
                        Quantity
                    </label>
                    <input
                        type="number"
                        wire:model="quantity"
                        id="quantity-mobile"
                        min="1"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white"
                    >
                    @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="color-mobile" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">
                        Color
                    </label>
                    <select
                        wire:model="selectedColor"
                        id="color-mobile"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white"
                    >
                        <option value="">Select Color</option>
                        @if (!empty($product->colors) && is_array($product->colors))
                            @foreach ($product->colors as $color)
                                <option value="{{ strtolower($color) }}">{{ ucfirst($color) }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <!-- Size -->
            <div>
                <label for="sizes-mobile" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">
                    Size
                </label>
                <select
                    wire:model="selectedSize"
                    id="sizes-mobile"
                    required
                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white"
                >
                    <option value="">Select a size</option>
                    @foreach ($product->sizes as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
                @error('selectedSize') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-400 text-white font-semibold rounded-md shadow-md transition duration-150"
                >
                    <span wire:loading.remove>
                        <i class="fa fa-cart-plus mr-2"></i> Add to Cart
                    </span>
                    <span wire:loading>
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Adding...
                    </span>
                </button>
                <a href="{{ route('home') }}"
                   class="flex-1 inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-gray-700 hover:bg-gray-800 rounded-md transition">
                    ← Continue Shopping
                </a>
            </div>
        </form>
    </div>

    {{--    <!-- Success Message -->--}}
    {{--    @if($showSuccess)--}}
    {{--        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">--}}
    {{--            <div class="flex items-center">--}}
    {{--                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">--}}
    {{--                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>--}}
    {{--                </svg>--}}
    {{--                Product added to cart successfully!--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    @endif--}}

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('hide-success', () => {
                setTimeout(() => {
                @this.hideSuccess()
                    ;
                }, 13000);
            });
        });
    </script>
</div>
