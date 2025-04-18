<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20"/>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20"/>
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
                <div class="p-6  dark:bg-zinc-800">
                    <div class="mt-6">
                        <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data" class="w-full space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
                                <div class="col-span-1">
                                    <label for="shoe_name" class="block text-sm font-medium text-gray-700 dark:text-white">Shoe Name</label>
                                    <input
                                        type="text"
                                        name="shoe_name"
                                        id="shoe_name"
                                        required
                                        class="mt-1 block w-full rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 shadow-sm focus:ring-indigo-500 dark:text-white"
                                    >
                                </div>

                                <div class="col-span-1">
                                    <label for="size" class="block text-sm font-medium text-gray-700 dark:text-white">Size</label>
                                    <input
                                        type="number"
                                        name="size"
                                        id="size"
                                        required
                                        min="1"
                                        max="50"
                                        class="mt-1 block w-full rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 shadow-sm focus:ring-indigo-500 dark:text-white"
                                    >
                                </div>

                                <div class="col-span-1">
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-white">Quantity</label>
                                    <input
                                        type="number"
                                        name="quantity"
                                        id="quantity"
                                        required
                                        min="1"
                                        class="mt-1 block w-full rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 shadow-sm focus:ring-indigo-500 dark:text-white"
                                    >
                                </div>

                                <div class="col-span-1">
                                    <label for="color" class="block text-sm font-medium text-gray-700 dark:text-white">Color</label>
                                    <input
                                        type="text"
                                        name="color"
                                        id="color"
                                        required
                                        class="mt-1 block w-full rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 shadow-sm focus:ring-indigo-500 dark:text-white"
                                    >
                                </div>

                                <div class="col-span-full">
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-white">Description</label>
                                    <textarea
                                        name="description"
                                        id="description"
                                        rows="3"
                                        placeholder="Optional notes about the shoe order..."
                                        class="mt-1 block w-full rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 shadow-sm focus:ring-indigo-500 dark:text-white"
                                    ></textarea>
                                </div>

                                <div class="col-span-full">
                                    <label for="sample_image" class="block text-sm font-medium text-gray-700 dark:text-white">Upload Sample Image</label>
                                    <input
                                        type="file"
                                        name="sample_image"
                                        id="sample_image"
                                        accept="image/*"
                                        class="mt-1 block w-full text-sm text-gray-900 dark:text-white file:bg-indigo-600 file:text-white file:py-2 file:px-4 file:rounded-md file:border-0 file:cursor-pointer"
                                    >
                                </div>
                            </div>

                            <div class="w-full">
                                <button
                                    type="submit"
                                    class="w-full mt-4 inline-flex items-center justify-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                >
                                    Place Order Now
                                </button>
                            </div>
                        </form>
                    </div>

                </div>


            </div>
        </div>
    </div>
    </div>
</x-layouts.app>
