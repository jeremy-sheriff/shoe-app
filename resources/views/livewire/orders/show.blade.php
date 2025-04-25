<x-layouts.app :title="__('Order Details')">
    <div class="flex  w-full flex-1 flex-col gap-4 rounded-xl">

        <div
            class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
                <div class="p-6 bg-white dark:bg-zinc-800 rounded-2xl shadow-md">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Order Details Section -->
                        <div class="rounded-lg border bg-gray-400 border-zinc-200 dark:border-zinc-700 p-4">
                            <h2 class="text-lg font-semibold text-white mb-4">Order Info</h2>
                            <div class="space-y-2">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-500">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                #
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Product Name
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Description
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Price (KSh)
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Created At
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($order->items as $index => $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->product->name ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->product->description ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($item->product->price ?? 0, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <!-- Order Metadata or Placeholder Section -->
                        <div
                            class="rounded-lg border bg-blue-100 dark:bg-zinc-700 border-zinc-200 dark:border-zinc-600 p-4">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Other Info</h2>
                            <div class="space-y-2 text-gray-900 dark:text-gray-200">
                                <div><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
                                <div><strong>Tracking ID:</strong> {{ $order->tracking_number }}</div>
                                <div><strong>Placed By:</strong> {{ $order->customer_name ?? 'N/A' }}</div>
                                <div><strong>Mpesa Number:</strong> {{ $order->mpesa_number ?? 'N/A' }}</div>
                                <div><strong>Placed On:</strong> {{ $order->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="grid  auto-rows-min gap-4 md:grid-cols-2">
            <div
                class="bg-gray-500 relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="space-y-2 p-6">
                    <form action="{{ route('orders.updateStatus', $order->uuid) }}" method="POST"
                          class="mt-6 space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-white">Order
                                Status</label>
                            <select name="status" id="status" required
                                    class="mt-1 block w-full rounded-md border-b-gray-800 dark:border-zinc-600 dark:bg-zinc-700 text-gray-900 dark:text-white">
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

    </div>
</x-layouts.app>
