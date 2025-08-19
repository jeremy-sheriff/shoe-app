<div>
    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-300 bg-clip-text text-transparent">
                        Orders Board
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400 mt-1">Manage your shoe orders with drag & drop</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl px-4 py-2 shadow-sm border border-slate-200 dark:border-slate-700">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Total Orders: </span>
                        <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">
                        {{ $orders->flatten()->count() }}
                    </span>
                    </div>
                </div>
            </div>
        </div>


        <!-- Kanban Board -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-data="kanbanBoard()" x-init="init()">
            @foreach($statusColumns as $status => $config)
                @php
                    $statusColor = $statusColors[$status] ?? 'slate';
                @endphp
                <div class="flex flex-col h-full">
                    <!-- Column Header -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-t-xl border-l-4 border-l-{{ $statusColor }}-500 shadow-sm">
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="text-lg">{{ $config['icon'] }}</span>
                                    <div>
                                        <h3 class="font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $config['title'] }}
                                        </h3>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $config['subtitle'] }}
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="bg-{{ $statusColor }}-100 dark:bg-{{ $statusColor }}-900 text-{{ $statusColor }}-700 dark:text-{{ $statusColor }}-300 rounded-full px-2 py-1 text-xs font-medium">
                                    {{ $orders[$status]->count() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Drop Zone -->
                    <div
                        class="flex-1 bg-white dark:bg-slate-800 rounded-b-xl border-t border-slate-200 dark:border-slate-700 shadow-sm"
                        x-bind:class="{
                         'ring-2 ring-{{ $statusColor }}-400 ring-opacity-50 bg-{{ $statusColor }}-50 dark:bg-{{ $statusColor }}-900/20': dragOverColumn === '{{ $status }}'
                     }">

                        <div class="p-4 min-h-[400px] space-y-3"
                             data-status="{{ $status }}"
                             x-on:dragover.prevent="handleDragOver('{{ $status }}')"
                             x-on:dragleave="handleDragLeave()"
                             x-on:drop.prevent="handleDrop($event, '{{ $status }}')">

                            @forelse($orders[$status] as $order)
                                <!-- Order Card -->
                                <div
                                    class="group bg-white dark:bg-slate-700 rounded-xl border border-slate-200 dark:border-slate-600 shadow-sm hover:shadow-md transition-all duration-200 cursor-move transform hover:scale-[1.02]"
                                    draggable="true"
                                    data-order-uuid="{{ $order->uuid }}"
                                    x-on:dragstart="handleDragStart($event, '{{ $order->uuid }}')"
                                    x-on:dragend="handleDragEnd()">

                                    <div class="p-4">
                                        <!-- Order Header -->
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-medium text-slate-900 dark:text-slate-100 truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                                    {{ $order->description ?? 'Shoe Order' }}
                                                </h4>
                                                <div class="flex items-center space-x-2 mt-1">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-600 text-slate-700 dark:text-slate-300">
                                                    #{{ substr($order->uuid, 0, 8) }}
                                                </span>
                                                </div>
                                            </div>
                                            <a href="{{ route('orders.show', $order->uuid) }}"
                                               class="ml-2 inline-flex items-center px-2 py-1 rounded-md text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                View
                                            </a>
                                        </div>

                                        <!-- Customer Info -->
                                        <div class="space-y-2">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                <span class="text-sm text-slate-600 dark:text-slate-300">
                                                {{ $order->customer_name ?? 'Guest Customer' }}
                                            </span>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span class="text-xs text-slate-500 dark:text-slate-400">
                                                    {{ $order->created_at->format('M d, Y') }}
                                                </span>
                                                </div>

                                                @if($order->priority ?? false)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300">
                                                    🔥 Priority
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Order Details -->
                                        @if($order->total_amount ?? false)
                                            <div class="mt-3 pt-3 border-t border-slate-100 dark:border-slate-600">
                                                <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                                    ${{ number_format($order->total_amount, 2) }}
                                                </span>
                                                    <div class="flex items-center space-x-1">
                                                        @for($i = 0; $i < 3; $i++)
                                                            <div
                                                                class="w-2 h-2 bg-{{ $statusColor }}-300 rounded-full opacity-{{ $i < 2 ? '100' : '30' }}"></div>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Drag Handle -->
                                    <div
                                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 8h16M4 16h16"/>
                                        </svg>
                                    </div>
                                </div>
                            @empty
                                <!-- Empty State -->
                                <div class="flex flex-col items-center justify-center py-12 text-center">
                                    <div
                                        class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">No orders
                                        in {{ strtolower($config['title']) }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Toast Notifications -->
        <div x-data="{ show: false, message: '', type: 'success' }"
             x-on:order-updated.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 3000)"
             x-show="show"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-4 right-4 z-50">

            <div
                class="max-w-sm w-full bg-white dark:bg-slate-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0" x-show="type === 'success'">
                            <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-shrink-0" x-show="type === 'error'">
                            <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-slate-900 dark:text-slate-100" x-text="message"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function kanbanBoard() {
            return {
                draggedOrder: null,
                dragOverColumn: null,

                init() {
                    // Initialize any additional setup
                },

                handleDragStart(event, orderUuid) {
                    this.draggedOrder = orderUuid;
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/html', event.target.outerHTML);

                    // Add drag styling
                    event.target.style.opacity = '0.5';

                @this.call('handleOrderDragged', orderUuid)
                    ;
                },

                handleDragEnd() {
                    // Reset styling
                    document.querySelectorAll('[draggable="true"]').forEach(el => {
                        el.style.opacity = '1';
                    });
                },

                handleDragOver(status) {
                    this.dragOverColumn = status;
                @this.call('handleDragOver', status)
                    ;
                },

                handleDragLeave() {
                    this.dragOverColumn = null;
                @this.call('handleDragLeave')
                    ;
                },

                handleDrop(event, newStatus) {
                    event.preventDefault();

                    if (this.draggedOrder) {
                    @this.call('handleOrderDropped', this.draggedOrder, newStatus)
                        ;
                    }

                    this.draggedOrder = null;
                    this.dragOverColumn = null;

                    // Reset all styling
                    document.querySelectorAll('[draggable="true"]').forEach(el => {
                        el.style.opacity = '1';
                    });
                }
            }
        }
    </script>

    @push('styles')
        <style>
            /* Custom scrollbar for columns */
            .kanban-column::-webkit-scrollbar {
                width: 6px;
            }

            .kanban-column::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 3px;
            }

            .kanban-column::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 3px;
            }

            .kanban-column::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            /* Dark mode scrollbar */
            .dark .kanban-column::-webkit-scrollbar-track {
                background: #1e293b;
            }

            .dark .kanban-column::-webkit-scrollbar-thumb {
                background: #475569;
            }

            .dark .kanban-column::-webkit-scrollbar-thumb:hover {
                background: #64748b;
            }
        </style>
    @endpush

</div>
