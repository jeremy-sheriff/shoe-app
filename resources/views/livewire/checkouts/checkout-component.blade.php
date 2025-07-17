<div>
    <!-- Checkout Form Section -->
    <div class="lg:col-span-3 bg-white dark:bg-zinc-800 p-6 rounded-xl shadow h-fit">
        <h2 class="text-xl font-bold mb-4 text-zinc-800 dark:text-white">Checkout</h2>

        <!-- Display Messages -->
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="submitOrder" class="space-y-4">
            <div>
                <label for="mpesa_number"
                       class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    M-Pesa Number
                </label>
                <input type="text"
                       wire:model.lazy="mpesa_number"
                       id="mpesa_number"
                       placeholder="e.g. 0712345678"
                       class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white @error('mpesa_number') border-red-500 @enderror">
                @error('mpesa_number')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <div class="mt-2 flex items-center gap-2">
                    <input type="checkbox"
                           wire:model="use_as_contact"
                           id="use_as_contact"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <label for="use_as_contact" class="text-sm text-zinc-700 dark:text-zinc-300">
                        <i>Use this number as my contact number</i>
                    </label>
                </div>

                @if($product)
                    <input name="product" value="{{ $product }}" type="hidden">
                @endif
            </div>

            <div>
                <label for="customer_name"
                       class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    Full Names
                </label>
                <input type="text"
                       wire:model.lazy="customer_name"
                       id="customer_name"
                       placeholder="e.g. John Doe"
                       class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white @error('customer_name') border-red-500 @enderror">
                @error('customer_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="town" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Town</label>
                <input type="text"
                       wire:model.lazy="town"
                       id="town"
                       placeholder="e.g. Westlands"
                       class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white @error('town') border-red-500 @enderror">
                @error('town')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="description"
                       class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Description</label>
                <textarea wire:model.lazy="description"
                          id="description"
                          rows="4"
                          placeholder="Please provide delivery instructions or any special requirements..."
                          class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white @error('description') border-red-500 @enderror"></textarea>
                @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="w-full px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow-md transition duration-150 disabled:opacity-50"
                        @if(count($cart) === 0) disabled @endif>
                    @if(count($cart) === 0)
                        Cart is Empty
                    @else
                        Confirm Order ({{ $this->formatCurrency($cartTotal) }})
                    @endif
                </button>
            </div>
        </form>
    </div>
</div>
