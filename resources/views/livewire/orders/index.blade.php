<div>
    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-300 bg-clip-text text-transparent">
                        Orders Board
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400 mt-2 text-lg">Manage your shoe orders with drag &
                        drop</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl px-6 py-3 shadow-lg border border-slate-200 dark:border-slate-700 backdrop-blur-sm">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Total Orders: </span>
                        <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                        {{ $orders->flatten()->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanban Board -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" x-data="kanbanBoard()" x-init="init()">
            @foreach($statusColumns as $status => $config)
                @php
                    // Define colors based on status
                    if($status === 'todo' || $status === 'pending' || $status === 'new') {
                        $statusColor = 'red';
                        $bgClass = 'bg-gradient-to-br from-red-50 to-red-100 dark:from-red-950 dark:to-red-900';
                        $borderClass = 'border-l-red-500';
                        $badgeClass = 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300';
                        $ringClass = 'ring-red-400 bg-red-50 dark:bg-red-900/20';
                    } elseif($status === 'in_progress' || $status === 'processing' || $status === 'working') {
                        $statusColor = 'orange';
                        $bgClass = 'bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-950 dark:to-orange-900';
                        $borderClass = 'border-l-orange-500';
                        $badgeClass = 'bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-300';
                        $ringClass = 'ring-orange-400 bg-orange-50 dark:bg-orange-900/20';
                    } else {
                        $statusColor = 'green';
                        $bgClass = 'bg-gradient-to-br from-green-50 to-green-100 dark:from-green-950 dark:to-green-900';
                        $borderClass = 'border-l-green-500';
                        $badgeClass = 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300';
                        $ringClass = 'ring-green-400 bg-green-50 dark:bg-green-900/20';
                    }
                @endphp
                <div class="flex flex-col h-full">
                    <!-- Column Header -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-t-2xl {{ $borderClass }} shadow-xl border-l-4 {{ $bgClass }} backdrop-blur-sm">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="text-2xl p-2 bg-white dark:bg-slate-700 rounded-xl shadow-md">{{ $config['icon'] }}</div>
                                    <div>
                                        <h3 class="font-bold text-xl text-slate-800 dark:text-slate-200">
                                            {{ $config['title'] }}
                                        </h3>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">
                                            {{ $config['subtitle'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="{{ $badgeClass }} rounded-full px-4 py-2 text-sm font-bold shadow-md">
                                    {{ $orders[$status]->count() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Drop Zone - FULL HEIGHT -->
                    <div
                        class="flex-1 bg-white dark:bg-slate-800 rounded-b-2xl border-t border-slate-200 dark:border-slate-700 shadow-xl min-h-[500px] flex flex-col"
                        x-bind:class="{
                             'ring-4 {{ $ringClass }} ring-opacity-50': dragOverColumn === '{{ $status }}'
                         }"
                        data-status="{{ $status }}"
                        x-on:dragover.prevent="handleDragOver('{{ $status }}')"
                        x-on:dragleave="handleDragLeave()"
                        x-on:drop.prevent="handleDrop($event, '{{ $status }}')">

                        <!-- Orders Container -->
                        <div class="p-6 flex-1 space-y-4">
                            @forelse($orders[$status] as $order)
                                <!-- Order Card -->
                                <div
                                    class="group bg-white dark:bg-slate-700 rounded-2xl border border-slate-200 dark:border-slate-600 shadow-lg hover:shadow-2xl transition-all duration-300 cursor-move transform hover:scale-105 hover:-rotate-1 relative overflow-hidden"
                                    draggable="true"
                                    data-order-uuid="{{ $order->uuid }}"
                                    x-on:dragstart="handleDragStart($event, '{{ $order->uuid }}')"
                                    x-on:dragend="handleDragEnd()">

                                    <!-- Status indicator stripe -->
                                    <div
                                        class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-{{ $statusColor }}-400 to-{{ $statusColor }}-600"></div>

                                    <div class="p-5">
                                        <!-- Order Header -->
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-bold text-lg text-slate-900 dark:text-slate-100 truncate group-hover:text-{{ $statusColor }}-600 dark:group-hover:text-{{ $statusColor }}-400 transition-colors">
                                                    {{ $order->description ?? 'Shoe Order' }}
                                                </h4>
                                                <div class="flex items-center space-x-2 mt-2">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-600 text-slate-700 dark:text-slate-300 shadow-sm">
                                                        #{{ substr($order->uuid, 0, 8) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <a href="{{ route('orders.show', $order->uuid) }}"
                                               class="ml-3 inline-flex items-center px-3 py-2 rounded-xl text-xs font-bold text-{{ $statusColor }}-600 dark:text-{{ $statusColor }}-400 hover:bg-{{ $statusColor }}-50 dark:hover:bg-{{ $statusColor }}-900/20 transition-all duration-200 shadow-sm hover:shadow-md">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
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
                                        <div class="space-y-3 bg-slate-50 dark:bg-slate-600/30 rounded-xl p-4">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="p-2 bg-{{ $statusColor }}-100 dark:bg-{{ $statusColor }}-900/30 rounded-lg">
                                                    <svg
                                                        class="w-4 h-4 text-{{ $statusColor }}-600 dark:text-{{ $statusColor }}-400"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                                                    {{ $order->customer_name ?? 'Guest Customer' }}
                                                </span>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="p-2 bg-slate-200 dark:bg-slate-700 rounded-lg">
                                                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400"
                                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                    </div>
                                                    <span
                                                        class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                                        {{ $order->created_at->format('M d, Y') }}
                                                    </span>
                                                </div>

                                                @if($order->priority ?? false)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 shadow-md animate-pulse">
                                                        🔥 Priority
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Order Details -->
                                        @if($order->total_amount ?? false)
                                            <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-600">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="text-lg font-bold text-slate-900 dark:text-slate-100">
                                                            ${{ number_format($order->total_amount, 2) }}
                                                        </span>
                                                        <span
                                                            class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-600 px-2 py-1 rounded-full">
                                                            Total
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center space-x-1">
                                                        @for($i = 0; $i < 3; $i++)
                                                            <div
                                                                class="w-3 h-3 bg-{{ $statusColor }}-400 rounded-full shadow-sm {{ $i < 2 ? 'opacity-100' : 'opacity-30' }}"></div>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Drag Handle -->
                                    <div
                                        class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-all duration-200 bg-white dark:bg-slate-600 rounded-lg p-2 shadow-md">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="M4 8h16M4 16h16"/>
                                        </svg>
                                    </div>
                                </div>
                            @empty
                                <!-- Empty State -->
                                <div class="flex flex-col items-center justify-center py-16 text-center">
                                    <div
                                        class="w-20 h-20 bg-gradient-to-br from-{{ $statusColor }}-100 to-{{ $statusColor }}-200 dark:from-{{ $statusColor }}-900 dark:to-{{ $statusColor }}-800 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                                        <svg
                                            class="w-10 h-10 text-{{ $statusColor }}-500 dark:text-{{ $statusColor }}-400"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">No orders
                                        in {{ strtolower($config['title']) }}</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Drag orders here to
                                        update status</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Toast Notifications -->
        <div x-data="{ show: false, message: '', type: 'success' }"
             x-on:order-updated.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 4000)"
             x-show="show"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-6 right-6 z-50">

            <div
                class="max-w-sm w-full bg-white dark:bg-slate-800 shadow-2xl rounded-2xl pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden backdrop-blur-sm border border-slate-200 dark:border-slate-700">
                <div class="p-5">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 p-2 bg-green-100 dark:bg-green-900 rounded-xl"
                             x-show="type === 'success'">
                            <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-shrink-0 p-2 bg-red-100 dark:bg-red-900 rounded-xl" x-show="type === 'error'">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-semibold text-slate-900 dark:text-slate-100" x-text="message"></p>
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
                    event.target.style.opacity = '0.6';
                    event.target.style.transform = 'rotate(5deg) scale(1.05)';

                @this.call('handleOrderDragged', orderUuid)
                    ;
                },

                handleDragEnd() {
                    // Reset styling
                    document.querySelectorAll('[draggable="true"]').forEach(el => {
                        el.style.opacity = '1';
                        el.style.transform = '';
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
                        el.style.transform = '';
                    });
                }
            }
        }
    </script>

    <style>
        /* Enhanced scrollbar styling */
        .kanban-column::-webkit-scrollbar {
            width: 8px;
        }

        .kanban-column::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 6px;
        }

        .kanban-column::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #cbd5e1, #94a3b8);
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .kanban-column::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #94a3b8, #64748b);
        }

        /* Dark mode scrollbar */
        .dark .kanban-column::-webkit-scrollbar-track {
            background: #1e293b;
        }

        .dark .kanban-column::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #475569, #334155);
            border: 1px solid #334155;
        }

        .dark .kanban-column::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #64748b, #475569);
        }

        /* Smooth animations */
        * {
            scroll-behavior: smooth;
        }
    </style>
</div>
