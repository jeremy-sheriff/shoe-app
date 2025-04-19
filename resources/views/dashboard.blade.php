<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        <!-- Stats Section -->
        <div class="grid gap-6 md:grid-cols-4 sm:grid-cols-2 grid-cols-1">
            <!-- Total Orders -->
            <div
                class="group relative p-6 bg-gradient-to-br from-white to-gray-50 dark:from-zinc-800 dark:to-zinc-900 border border-neutral-200/70 dark:border-neutral-700 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/10 dark:to-purple-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</div>
                        <div
                            class="p-2 rounded-lg bg-indigo-100/50 dark:bg-indigo-900/20 group-hover:bg-indigo-100/70 dark:group-hover:bg-indigo-900/30 transition-colors">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                                 stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 flex items-end justify-between">
                        <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalOrders }}</div>
                        <div class="flex items-center text-sm font-medium text-green-500 dark:text-green-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            12%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Processing -->
            <div
                class="group relative p-6 bg-gradient-to-br from-white to-gray-50 dark:from-zinc-800 dark:to-zinc-900 border border-neutral-200/70 dark:border-neutral-700 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-amber-900/10 dark:to-yellow-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Processing</div>
                        <div
                            class="p-2 rounded-lg bg-amber-100/50 dark:bg-amber-900/20 group-hover:bg-amber-100/70 dark:group-hover:bg-amber-900/30 transition-colors">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                                 stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 flex items-end justify-between">
                        <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $processingOrders }}</div>
                        <div class="flex items-center text-sm font-medium text-amber-500 dark:text-amber-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            8%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed -->
            <div
                class="group relative p-6 bg-gradient-to-br from-white to-gray-50 dark:from-zinc-800 dark:to-zinc-900 border border-neutral-200/70 dark:border-neutral-700 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/10 dark:to-emerald-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed</div>
                        <div
                            class="p-2 rounded-lg bg-green-100/50 dark:bg-green-900/20 group-hover:bg-green-100/70 dark:group-hover:bg-green-900/30 transition-colors">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                                 stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 flex items-end justify-between">
                        <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $completedOrders }}</div>
                        <div class="flex items-center text-sm font-medium text-green-500 dark:text-green-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            24%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cancelled -->
            <div
                class="group relative p-6 bg-gradient-to-br from-white to-gray-50 dark:from-zinc-800 dark:to-zinc-900 border border-neutral-200/70 dark:border-neutral-700 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-red-50 to-rose-50 dark:from-red-900/10 dark:to-rose-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Cancelled</div>
                        <div
                            class="p-2 rounded-lg bg-red-100/50 dark:bg-red-900/20 group-hover:bg-red-100/70 dark:group-hover:bg-red-900/30 transition-colors">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                 stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 flex items-end justify-between">
                        <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $cancelledOrders }}</div>
                        <div class="flex items-center text-sm font-medium text-red-500 dark:text-red-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                            4%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Placeholder for Chart or List Below -->
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-gradient-to-br from-white to-gray-50 dark:from-zinc-800 dark:to-zinc-900">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center p-6 max-w-md">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Analytics Dashboard</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Your data visualization will appear here.
                        Connect your data source to see beautiful charts and graphs.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
