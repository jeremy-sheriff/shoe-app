<x-layouts.app :title="__('Dashboard')">
    <div class="flex flex-col gap-6 h-full w-full">

        {{-- Top Section with Form and Empty Right Side --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Left: Product Form --}}
            <div
                class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 bg-white dark:bg-zinc-800 h-fit md:col-span-2">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                      class="space-y-8">
                    @csrf

                    <!-- Category and Shoe Name side by side -->
                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Category -->
                        <div class="w-full md:w-1/2 space-y-2">
                            <label for="category" class="block text-sm font-medium text-gray-800 dark:text-white">Category</label>
                            <select name="category" id="category" required
                                    class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Shoe Name -->
                        <div class="w-full md:w-1/2 space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-white">Shoe
                                Name</label>
                            <input name="name" id="name" required
                                   class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white">
                        </div>
                    </div>


                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Price -->
                        <div class="w-full md:w-1/2 space-y-2">
                            <label for="price" class="block text-sm font-medium text-gray-800 dark:text-white">Price
                                (Ksh)</label>
                            <input type="number" name="price" id="price" step="50" min="100" required
                                   class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Available colors -->
                        <div class="w-full md:w-1/2 space-y-2">
                            <label for="color" class="block text-sm font-medium text-gray-800 dark:text-white">Available
                                colors</label>

                            <div class="flex flex-wrap gap-4">
                                @php
                                    $colors = ['Black', 'White', 'Red', 'Blue'];
                                @endphp

                                @foreach ($colors as $color)
                                    <label class="flex items-center space-x-2 text-sm text-gray-700 dark:text-white">
                                        <input
                                            type="checkbox"
                                            name="colors[]"
                                            value="{{ strtolower($color) }}"
                                            class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary"
                                        >
                                        <span>{{ $color }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="w-full  space-y-2">
                        <label for="description" class="block text-sm font-medium text-gray-800 dark:text-white">Description</label>
                        <textarea name="description" id="description" rows="4" required
                                  class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>


                    <!-- Image Uploads -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-black mb-2">Upload
                            Images</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Image 1 -->
                            <div class="slim border-2 border-dashed rounded-lg p-4" data-label="Drop your image here"
                                 data-size="240,240" data-ratio="1:1">
                                <input type="file" name="slim[]" required/>
                            </div>
                            <!-- Image 2 -->
                            <div class="slim border-2 border-dashed rounded-lg p-4" data-size="240,240"
                                 data-ratio="1:1">
                                <input type="file" name="slim[]"/>
                            </div>
                            <!-- Image 3 -->
                            <div class="slim border-2 border-dashed rounded-lg p-4" data-size="240,240"
                                 data-ratio="1:1">
                                <input type="file" name="slim[]"/>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                                class="w-full sm:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow-sm transition duration-200 ease-in-out">
                            Add Product
                        </button>
                    </div>
                </form>

            </div>


            {{-- Right: Empty Section --}}
            <div
                class="md:col-span-1 rounded-xl border border-dashed border-neutral-300 dark:border-neutral-700 p-6 bg-white dark:bg-zinc-800 flex items-center justify-center">
                <span class="text-zinc-400 dark:text-zinc-500">
                    Here
                </span>
            </div>
        </div>

        {{-- Full-width Product Table --}}
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 bg-white dark:bg-zinc-800 w-full">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">Products!</h2>
            </div>


            <div class="overflow-x-auto border border-zinc-200 dark:border-zinc-700 rounded-lg">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700 text-sm text-left">
                    <thead
                        class="bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-200 uppercase tracking-wide text-xs">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 text-zinc-800 dark:text-zinc-100">
                    @forelse ($products as $product)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $product->name }}</td>
                            <td class="px-4 py-3">KSh {{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-3">{{ $product->stock }}</td>
                            <td class="px-4 py-3">{{ $product->sku }}</td>
                            <td class="px-4 py-3">
                                    <span class="inline-block px-2 py-1 text-xs rounded
                                        {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="text-blue-600 hover:underline mr-1">Edit</a>
                                <button class="mt-3 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md shadow-sm transition duration-150 ease-in-out">
                                    Delete
                                </button>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-zinc-500">No products found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
