<div
    class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-5xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-300 bg-clip-text text-transparent">
                    Orders Board
                </h1>
                <p class="text-slate-600 dark:text-slate-400 mt-3 text-xl font-medium">Manage your shoe orders with
                    seamless drag & drop</p>
            </div>
            <div class="flex items-center space-x-3">
                <div
                    class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl px-8 py-4 shadow-2xl border border-white/20 dark:border-slate-700/50">
                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">Total Orders: </span>
                    <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
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
                    class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-t-3xl {{ $borderClass }} shadow-2xl border-l-4 {{ $bgClass }} relative overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="text-3xl p-4 bg-white/90 dark:bg-slate-700/90 backdrop-blur-sm rounded-2xl shadow-lg">{{ $config['icon'] }}</div>
                                <div>
                                    <h3 class="font-bold text-2xl text-slate-800 dark:text-slate-200">{{ $config['title'] }}</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">{{ $config['subtitle'] }}</p>
                                </div>
                            </div>
                            <div
                                class="{{ $badgeClass }} rounded-2xl px-5 py-3 text-sm font-bold shadow-lg border-2 border-white/30">
                                {{ $orders[$status]->count() }}
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-{{ $statusColor }}-400 to-{{ $statusColor }}-600 opacity-70"></div>
                </div>

                <!-- Drop Zone -->
                <div
                    class="flex-1 bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-b-3xl border-t border-slate-200/50 dark:border-slate-700/50 shadow-2xl min-h-[600px] flex flex-col transition-all duration-300"
                    x-bind:class="{
                         'ring-4 {{ $ringClass }} ring-opacity-50 transform scale-[1.02] bg-{{ $statusColor }}-50/20 dark:bg-{{ $statusColor }}-900/10': dragOverColumn === '{{ $status }}'
                     }"
                    data-status="{{ $status }}"
                    x-on:dragover.prevent="handleDragOver($event, '{{ $status }}')"
                    x-on:dragleave="handleDragLeave()"
                    x-on:drop.prevent="handleDrop($event, '{{ $status }}')">

                    <!-- Orders Container -->
                    <div class="p-6 flex-1 space-y-4" id="column-{{ $status }}">
                        @forelse($orders[$status] as $order)
                            <!-- Order Card -->
                            <div
                                class="group bg-white/90 dark:bg-slate-700/90 backdrop-blur-sm rounded-3xl border border-slate-200/50 dark:border-slate-600/50 shadow-xl cursor-move relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-[1.02] hover:-translate-y-1 @if($order->priority ?? false) ring-2 ring-red-400/50 @endif"
                                draggable="true"
                                data-order-uuid="{{ $order->uuid }}"
                                data-order-index="{{ $loop->index }}"
                                x-on:dragstart="handleDragStart($event, '{{ $order->uuid }}', '{{ $status }}', {{ $loop->index }})"
                                x-on:dragend="handleDragEnd()"
                                x-bind:class="{
                                     'opacity-60 transform rotate-2 scale-105 shadow-2xl z-50': draggedOrder === '{{ $order->uuid }}'
                                 }">

                                @if($order->priority ?? false)
                                    <!-- Priority Indicator -->
                                    <div
                                        class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-red-400 via-orange-400 to-red-600 animate-pulse"></div>
                                @else
                                    <!-- Status Indicator -->
                                    <div
                                        class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-{{ $statusColor }}-400 to-{{ $statusColor }}-600 opacity-70"></div>
                                @endif

                                <div class="p-6">
                                    <!-- Order Header -->
                                    <div class="flex items-start justify-between mb-6">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-xl text-slate-900 dark:text-slate-100 truncate group-hover:text-{{ $statusColor }}-600 dark:group-hover:text-{{ $statusColor }}-400 transition-colors duration-300 leading-tight">
                                                {{ $order->description ?? 'Custom Shoe Order' }}
                                            </h4>
                                            <div class="flex items-center space-x-3 mt-3">
                                                <span
                                                    class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold bg-slate-100/80 dark:bg-slate-600/80 text-slate-700 dark:text-slate-300 shadow-md backdrop-blur-sm">
                                                    #{{ substr($order->uuid, 0, 8) }}
                                                </span>
                                                @if($order->priority ?? false)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100/80 dark:bg-red-900/80 text-red-700 dark:text-red-300 shadow-md animate-pulse backdrop-blur-sm">
                                                        🔥 Priority
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <a href="{{ route('orders.show', $order->uuid) }}"
                                           class="ml-4 inline-flex items-center px-4 py-3 rounded-2xl text-sm font-bold text-{{ $statusColor }}-600 dark:text-{{ $statusColor }}-400 hover:bg-{{ $statusColor }}-50/80 dark:hover:bg-{{ $statusColor }}-900/20 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 backdrop-blur-sm">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View Details
                                        </a>
                                    </div>

                                    <!-- Customer Info Section -->
                                    <div
                                        class="space-y-4 bg-gradient-to-br from-slate-50/80 to-slate-100/50 dark:from-slate-700/30 dark:to-slate-600/20 backdrop-blur-sm rounded-2xl p-5 border border-slate-200/30 dark:border-slate-600/30">
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="p-3 bg-{{ $statusColor }}-100/80 dark:bg-{{ $statusColor }}-900/30 backdrop-blur-sm rounded-2xl shadow-md">
                                                <svg
                                                    class="w-5 h-5 text-{{ $statusColor }}-600 dark:text-{{ $statusColor }}-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <span
                                                    class="text-lg font-bold text-slate-800 dark:text-slate-200">{{ $order->customer_name ?? 'Guest Customer' }}</span>
                                                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">
                                                    Customer</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="p-2 bg-slate-200/80 dark:bg-slate-700/80 backdrop-blur-sm rounded-xl shadow-sm">
                                                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <span
                                                        class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $order->created_at->format('M d, Y') }}</span>
                                                    <p class="text-xs text-slate-500 dark:text-slate-400">Order Date</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center space-x-2">
                                                <div
                                                    class="w-3 h-3 bg-{{ $statusColor }}-400 rounded-full shadow-sm opacity-100 scale-100 transition-all duration-300"></div>
                                                <div
                                                    class="w-3 h-3 bg-{{ $statusColor }}-400 rounded-full shadow-sm opacity-100 scale-100 transition-all duration-300"></div>
                                                <div
                                                    class="w-3 h-3 bg-{{ $statusColor }}-200 rounded-full shadow-sm opacity-50 scale-75 transition-all duration-300"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Order Total -->
                                    @if($order->total_amount ?? false)
                                        <div class="mt-5 pt-5 border-t border-slate-200/50 dark:border-slate-600/30">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-2xl font-bold text-slate-900 dark:text-slate-100">${{ number_format($order->total_amount, 2) }}</span>
                                                    <span
                                                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 bg-slate-100/80 dark:bg-slate-600/80 backdrop-blur-sm px-3 py-2 rounded-full shadow-sm">
                                                        Total Amount
                                                    </span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-ping"></div>
                                                    <span
                                                        class="text-xs font-medium text-green-600 dark:text-green-400">Active</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Drag Handle -->
                                <div
                                    class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 bg-white/90 dark:bg-slate-600/90 backdrop-blur-sm rounded-2xl p-3 shadow-lg">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 8h16M4 16h16"/>
                                    </svg>
                                </div>

                                <!-- Sliding placeholder will be inserted here dynamically -->
                            </div>
                        @empty
                            <!-- Empty State -->
                            <div class="flex flex-col items-center justify-center py-20 text-center">
                                <div
                                    class="w-24 h-24 bg-gradient-to-br from-{{ $statusColor }}-100 to-{{ $statusColor }}-200 dark:from-{{ $statusColor }}-900 dark:to-{{ $statusColor }}-800 rounded-3xl flex items-center justify-center mb-6 shadow-xl">
                                    <svg class="w-12 h-12 text-{{ $statusColor }}-500 dark:text-{{ $statusColor }}-400"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-slate-600 dark:text-slate-400 mb-2">No orders yet</h4>
                                <p class="text-sm text-slate-500 dark:text-slate-500">Drag orders here to update their
                                    status</p>
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
            class="max-w-sm w-full bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl shadow-2xl rounded-2xl pointer-events-auto ring-1 ring-black/5 overflow-hidden border border-white/20 dark:border-slate-700/50">
            <div class="p-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 p-3 bg-green-100/80 dark:bg-green-900/80 backdrop-blur-sm rounded-2xl"
                         x-show="type === 'success'">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-shrink-0 p-3 bg-red-100/80 dark:bg-red-900/80 backdrop-blur-sm rounded-2xl"
                         x-show="type === 'error'">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-slate-900 dark:text-slate-100" x-text="message"></p>
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
            draggedFromColumn: null,
            draggedFromIndex: null,
            dragOverColumn: null,
            placeholder: null,

            init() {
                // Create a dynamic placeholder element for smooth drop animation
                this.placeholder = document.createElement("div");
                this.placeholder.className = "h-32 mx-2 my-4 border-4 border-dashed border-indigo-300 dark:border-indigo-600 bg-indigo-50 dark:bg-indigo-900/20 rounded-3xl opacity-70 transition-all duration-300 flex items-center justify-center";
                this.placeholder.innerHTML = '<div class="text-indigo-500 dark:text-indigo-400 font-medium text-sm">Drop here</div>';
            },

            handleDragStart(event, orderUuid, fromColumn, fromIndex) {
                this.draggedOrder = orderUuid;
                this.draggedFromColumn = fromColumn;
                this.draggedFromIndex = fromIndex;

                event.dataTransfer.effectAllowed = "move";
                event.dataTransfer.setData("text/plain", orderUuid);

                // Call Livewire method
            @this.call("handleOrderDragged", orderUuid)
                ;
            },

            handleDragEnd() {
                // Clean up placeholder
                if (this.placeholder.parentNode) {
                    this.placeholder.parentNode.removeChild(this.placeholder);
                }

                // Remove sliding effect from all cards
                document.querySelectorAll('[data-order-uuid]').forEach(card => {
                    card.style.transform = '';
                    card.style.transition = '';
                });

                // Reset state
                this.draggedOrder = null;
                this.draggedFromColumn = null;
                this.draggedFromIndex = null;
                this.dragOverColumn = null;
            },

            handleDragOver(event, status) {
                this.dragOverColumn = status;

                if (!this.draggedOrder) return;

                const column = document.getElementById(`column-${status}`);
                if (!column) return;

                const cards = Array.from(column.querySelectorAll('[data-order-uuid]')).filter(
                    card => card.getAttribute('data-order-uuid') !== this.draggedOrder
                );

                const mouseY = event.clientY;

                // Reset all card positions
                cards.forEach(card => {
                    card.style.transform = '';
                    card.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                });

                // Find insertion point
                let insertIndex = cards.length;
                for (let i = 0; i < cards.length; i++) {
                    const card = cards[i];
                    const rect = card.getBoundingClientRect();
                    const cardCenter = rect.top + rect.height / 2;

                    if (mouseY < cardCenter) {
                        insertIndex = i;
                        break;
                    }
                }

                // Apply slide down effect to cards that will move
                for (let i = insertIndex; i < cards.length; i++) {
                    cards[i].style.transform = 'translateY(140px)';
                }

                // Position placeholder
                if (insertIndex === cards.length) {
                    column.appendChild(this.placeholder);
                } else {
                    column.insertBefore(this.placeholder, cards[insertIndex]);
                }

                // Call Livewire method
            @this.call("handleDragOver", status)
                ;
            },

            handleDragLeave() {
                // Remove placeholder
                if (this.placeholder.parentNode) {
                    this.placeholder.parentNode.removeChild(this.placeholder);
                }

                // Reset card positions
                document.querySelectorAll('[data-order-uuid]').forEach(card => {
                    card.style.transform = '';
                });

                this.dragOverColumn = null;
            @this.call("handleDragLeave")
                ;
            },

            handleDrop(event, newStatus) {
                event.preventDefault();

                if (this.draggedOrder) {
                @this.call("handleOrderDropped", this.draggedOrder, newStatus)
                    ;
                }

                // Clean up
                this.handleDragEnd();
            }
        }
    }
</script>
