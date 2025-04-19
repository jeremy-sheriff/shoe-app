<x-layouts.app :title="__('Order Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                @if($order->image_path)
                    <div class="md:col-span-2">
                        <strong>Sample Image:</strong><br>
                        <img alt="{{$order->image_path}}" width="250px" height="200px"
                             src="{{ asset('storage/' . $order->image_path) }}"
                             class="w-64 h-auto rounded-lg shadow">
                    </div>
                @endif
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="space-y-2 p-6">
                    <form action="{{ route('orders.updateStatus', $order->uuid) }}" method="POST"
                          class="mt-6 space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-white">Order
                                Status</label>
                            <select name="status" id="status" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 text-gray-900 dark:text-white">
                                <option value="">Select Status</option>
                                @foreach(['pending', 'processing', 'completed', 'cancelled'] as $statusOption)
                                    <option
                                        value="{{ $statusOption }}" {{ $order->status === $statusOption ? 'selected' : '' }}>
                                        {{ ucfirst($statusOption) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <button type="submit" style="background: black"
                                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow">
                                Update Status
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20"/>
            </div>
        </div>
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
                <div class="p-6 bg-white dark:bg-zinc-800 rounded-2xl shadow-md">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Order Details Section -->
                        <div class="rounded-lg border bg-red-400 border-zinc-200 dark:border-zinc-700 p-4">
                            <h2 class="text-lg font-semibold text-white mb-4">Order Info</h2>
                            <div class="space-y-2">
                                <div><strong>Shoe Name:</strong> {{ $order->shoe_name }}</div>
                                <div><strong>Size:</strong> {{ $order->size }}</div>
                                <div><strong>Color:</strong> {{ $order->color }}</div>
                                <div><strong>Quantity:</strong> {{ $order->quantity }}</div>
                                <div><strong>Description:</strong> {{ $order->description }}</div>
                            </div>
                        </div>

                        <!-- Order Metadata or Placeholder Section -->
                        <div
                            class="rounded-lg border bg-blue-100 dark:bg-zinc-700 border-zinc-200 dark:border-zinc-600 p-4">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Other Info</h2>
                            <div class="space-y-2 text-gray-900 dark:text-gray-200">
                                <div><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
                                <div><strong>Order ID:</strong> {{ $order->uuid }}</div>
                                <div><strong>Placed By:</strong> {{ $order->user->name ?? 'N/A' }}</div>
                                <div><strong>Placed On:</strong> {{ $order->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>
