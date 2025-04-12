
<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
                <div class="p-6 bg-white dark:bg-zinc-800 rounded-2xl shadow-md">


                    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
                        <table class="min-w-full text-sm text-left">
                            <thead
                                class="bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-100 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Description</th>
                                <th class="px-6 py-3">Customer</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Order Date</th>
                            </tr>
                            </thead>
                            <tbody class="text-zinc-800 dark:text-zinc-100 divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">{{ $order->description }}</td>
                                    <td class="px-6 py-4">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 capitalize">
                            <span class="inline-flex px-2 py-1 rounded text-xs font-medium
                                @class([
                                    'bg-yellow-100 text-yellow-800' => $order->status === 'pending',
                                    'bg-blue-100 text-blue-800' => $order->status === 'processing',
                                    'bg-green-100 text-green-800' => $order->status === 'shipped',
                                    'bg-gray-200 text-gray-800' => $order->status === 'delivered',
                                ])
                            ">
                                {{ $order->status }}
                            </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">
                                        No orders found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
