<div>
    <!-- Desktop Cart Table -->
    <div class="hidden lg:block">
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
                    <th class="p-3">Size</th>
                    <th class="p-3">Qty</th>
                    <th class="p-3">Subtotal</th>
                    <th class="p-3">Action</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse($cart as $cartKey => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <td class="p-3">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}"
                                     class="w-16 h-16 object-cover rounded"
                                     alt="{{ $item['name'] }}">
                            @else
                                <div
                                    class="w-16 h-16 bg-gray-200 dark:bg-zinc-700 rounded flex items-center justify-center">
                                    <span class="text-xs text-gray-500">No Image</span>
                                </div>
                            @endif
                        </td>
                        <td class="p-3 font-medium">{{ $item['name'] }}</td>
                        <td class="p-3">KSh {{ number_format($item['price'], 2) }}</td>
                        <td class="p-3 capitalize">{{ $item['color'] ?: 'N/A' }}</td>
                        <td class="p-3">{{ $item['size'] ?: 'N/A' }}</td>
                        <td class="p-3">
                            <div class="flex items-center gap-2">
                                <button
                                    wire:click="decreaseQuantity('{{ $cartKey }}')"
                                    class="px-2 py-1 bg-gray-200 dark:bg-zinc-700 rounded hover:bg-gray-300 dark:hover:bg-zinc-600 transition"
                                >
                                    -
                                </button>
                                <span class="px-2">{{ $item['quantity'] }}</span>
                                <button
                                    wire:click="increaseQuantity('{{ $cartKey }}')"
                                    class="px-2 py-1 bg-gray-200 dark:bg-zinc-700 rounded hover:bg-gray-300 dark:hover:bg-zinc-600 transition"
                                >
                                    +
                                </button>
                            </div>
                        </td>
                        <td class="p-3 font-semibold">KSh {{ number_format($subtotal, 2) }}</td>
                        <td class="p-3">
                            <button
                                wire:click="removeItem('{{ $cartKey }}')"
                                wire:confirm="Are you sure you want to remove this item?"
                                class="text-red-500 hover:text-red-700 hover:underline text-sm transition"
                            >
                                Remove
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-6 text-center text-zinc-500 dark:text-zinc-400">
                            Your cart is empty.
                        </td>
                    </tr>
                @endforelse

                @if(count($cart) > 0)
                    <tr class="bg-zinc-100 dark:bg-zinc-800 font-bold">
                        <td colspan="6" class="p-3 text-right">Total</td>
                        <td class="p-3">KSh {{ number_format($cartTotal, 2) }}</td>
                        <td></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>


    <!-- Mobile Cart Display -->
    <div class="block lg:hidden">
        <h2 class="text-xl font-bold mb-4 text-zinc-800 dark:text-white">Your Cart</h2>
        @if(count($cart) > 0)
            <div class="space-y-4">
                @foreach($cart as $cartKey => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; @endphp
                    <div class="bg-white dark:bg-zinc-800 rounded-lg p-4 shadow">
                        <div class="flex items-start space-x-4">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}"
                                     class="w-16 h-16 object-cover rounded"
                                     alt="{{ $item['name'] }}">
                            @else
                                <div
                                    class="w-16 h-16 bg-gray-200 dark:bg-zinc-700 rounded flex items-center justify-center">
                                    <span class="text-xs text-gray-500">No Image</span>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-zinc-900 dark:text-white truncate">{{ $item['name'] }}</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                    KSh {{ number_format($item['price'], 2) }}
                                    @if($item['color'] ?? null)
                                        • {{ ucfirst($item['color']) }}
                                    @endif
                                    @if($item['size'] ?? null)
                                        • {{ $item['size'] }}
                                    @endif
                                </p>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center space-x-2">
                                        <button
                                            wire:click="decreaseQuantity('{{ $cartKey }}')"
                                            class="w-8 h-8 bg-gray-200 dark:bg-zinc-700 rounded-full flex items-center justify-center text-sm hover:bg-gray-300 dark:hover:bg-zinc-600 transition"
                                        >
                                            -
                                        </button>
                                        <span
                                            class="px-2 py-1 bg-gray-100 dark:bg-zinc-700 rounded text-sm">{{ $item['quantity'] }}</span>
                                        <button
                                            wire:click="increaseQuantity('{{ $cartKey }}')"
                                            class="w-8 h-8 bg-gray-200 dark:bg-zinc-700 rounded-full flex items-center justify-center text-sm hover:bg-gray-300 dark:hover:bg-zinc-600 transition"
                                        >
                                            +
                                        </button>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-zinc-900 dark:text-white">
                                            KSh {{ number_format($subtotal, 2) }}
                                        </p>
                                        <button
                                            wire:click="removeItem('{{ $cartKey }}')"
                                            wire:confirm="Are you sure you want to remove this item?"
                                            class="text-red-500 hover:text-red-700 hover:underline text-sm transition"
                                        >
                                            Remove
                                        </button>
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
</div>
