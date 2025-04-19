<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        <!-- Stats Section -->
        <div class="grid gap-6 md:grid-cols-4 sm:grid-cols-2 grid-cols-1">
            <!-- Total Orders -->
            <div
                class="p-5 bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Orders</div>
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M3 3h18v18H3V3z"/>
                    </svg>
                </div>
                <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalOrders }}</div>
            </div>

            <!-- Processing -->
            <div
                class="p-5 bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300">Processing</div>
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3"/>
                    </svg>
                </div>
                <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $processingOrders }}</div>
            </div>

            <!-- Completed -->
            <div
                class="p-5 bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300">Completed</div>
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $completedOrders }}</div>
            </div>

            <!-- Cancelled -->
            <div
                class="p-5 bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300">Cancelled</div>
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $cancelledOrders }}</div>
            </div>
        </div>

        <!-- Placeholder for Chart or List Below -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts.app>
