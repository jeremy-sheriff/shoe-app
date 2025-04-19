<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
            {{-- Left Form Card --}}
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm bg-gray-50 dark:bg-zinc-800">
                <div class="p-6 space-y-6">
                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-100 p-4 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="mb-4 rounded-md bg-red-100 p-4 text-red-700">
                            <strong>There were some problems with your input:</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="shoe_name" class="block text-sm font-medium text-gray-700 dark:text-white">Shoe Name</label>
                                <input type="text" name="shoe_name" id="shoe_name" required
                                       class="mt-1 block w-full rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 shadow-sm focus:ring-indigo-500 dark:text-white">
                            </div>
                            <div>
                                <label for="size" class="block text-sm font-medium text-gray-700 dark:text-white">Size</label>
                                <input type="number" name="size" id="size" min="1" max="50" required
                                       class="mt-1 block w-full rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 shadow-sm focus:ring-indigo-500 dark:text-white">
                            </div>
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-white">Quantity</label>
                                <input type="number" name="quantity" id="quantity" min="1" required
                                       class="mt-1 block w-full rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 shadow-sm focus:ring-indigo-500 dark:text-white">
                            </div>
                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700 dark:text-white">Color</label>
                                <input type="text" name="color" id="color" required
                                       class="mt-1 block w-full rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 shadow-sm focus:ring-indigo-500 dark:text-white">
                            </div>
                        </div>

                        {{-- Full Width Description --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-white">Description</label>
                            <textarea name="description" id="description" rows="3" placeholder="Optional notes about the shoe order..."
                                      class="mt-1 block w-full rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 shadow-sm focus:ring-indigo-500 dark:text-white"></textarea>
                        </div>

                        {{-- Full Width Upload --}}
                        <div>
                            <label for="sample_image" class="block text-sm font-medium text-gray-700 dark:text-white">Upload Sample Image</label>
                            <input type="file" name="sample_image" id="sample_image" accept="image/*"
                                   class="">
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2" style="background: black;">
                            <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md shadow-sm transition duration-150 ease-in-out">
                                Place Order Now
                            </button>
                        </div>


                    </form>
                </div>
            </div>

            {{-- Right Side Placeholder --}}
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20"/>
            </div>
        </div>

        {{-- Customer Orders Section --}}
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800">
            <div class="flex h-full w-full flex-1 flex-col gap-4 p-6">
                <div class="p-6 bg-white dark:bg-zinc-800 rounded-2xl shadow-md">


                    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
                        <table class="min-w-full text-sm text-left">
                            <thead
                                class="bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-100 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Description</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Order Date</th>
                                <th class="px-6 py-3">Order Sample</th>
                            </tr>
                            </thead>
                            <tbody class="text-zinc-800 dark:text-zinc-100 divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">{{ $order->description }}</td>
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
                                    <td>
                                        @if ($order->image_path)
                                            <img height="40px" width="40px" src="{{ asset('storage/' . $order->image_path) }}" alt="Sample Image" class="w-20 h-20 object-cover rounded-md shadow">
                                        @endif
                                    </td>

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
