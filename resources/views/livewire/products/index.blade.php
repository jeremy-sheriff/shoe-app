<x-layouts.app :title="__('Dashboard')">
    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-gray-900 dark:to-gray-800 p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-8">

            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-red-800 dark:text-red-200">Input Errors</h3>
                            <ul class="mt-2 text-sm text-red-700 dark:text-red-300 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-center">
                                        <span class="w-1 h-1 bg-red-400 rounded-full mr-2"></span>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Header --}}
            <div class="text-center space-y-4">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                    Product Management</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">Add and manage your product inventory</p>
            </div>
            <flux:modal variant="flyout" name="edit-profile">
                <div class="space-y-6">
                    {{-- Main Content Grid --}}
                    <div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- Product Form --}}
                        <div class="xl:col-span-3">
                            <div
                                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6">
                                    <h2 class="text-2xl font-bold text-white">Add New Product</h2>
                                    <p class="text-indigo-100 mt-1">Fill in the details to create a new product</p>
                                </div>

                                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                                      class="p-8 space-y-8">
                                    @csrf

                                    <!-- Image Uploads -->
                                    <div class="space-y-4">
                                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Product
                                            Images</h3>
                                        @error('slim')
                                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                                        @enderror
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <!-- Image 1 -->
                                            <div
                                                class="slim group relative bg-gray-50 dark:bg-gray-700 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 hover:border-indigo-400 hover:bg-indigo-50 dark:hover:bg-gray-600 transition-all duration-200"
                                                data-label="Drop your image here" data-size="500,500" data-ratio="1:1">
                                                <div class="text-center">

                                                    <p class="mt-2 text-sm font-medium text-gray-600 dark:text-gray-400 group-hover:text-indigo-600">
                                                        Upload Image</p>
                                                </div>
                                                <input type="file" name="slim[]" required
                                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"/>
                                            </div>
                                            <!-- Image 2 -->
                                            <div
                                                class="slim group relative bg-gray-50 dark:bg-gray-700 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 hover:border-indigo-400 hover:bg-indigo-50 dark:hover:bg-gray-600 transition-all duration-200"
                                                data-size="500,500" data-ratio="1:1">
                                                <div class="text-center">
                                                    <svg
                                                        class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition-colors duration-200"
                                                        stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                        <path
                                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"/>
                                                    </svg>
                                                    <p class="mt-2 text-sm font-medium text-gray-600 dark:text-gray-400 group-hover:text-indigo-600">
                                                        Upload Image</p>
                                                </div>
                                                <input type="file" name="slim[]"
                                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"/>
                                            </div>
                                            <!-- Image 3 -->
                                            <div
                                                class="slim group relative bg-gray-50 dark:bg-gray-700 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 hover:border-indigo-400 hover:bg-indigo-50 dark:hover:bg-gray-600 transition-all duration-200"
                                                data-size="500,500" data-ratio="1:1">
                                                <div class="text-center">
                                                    <svg
                                                        class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition-colors duration-200"
                                                        stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                        <path
                                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"/>
                                                    </svg>
                                                    <p class="mt-2 text-sm font-medium text-gray-600 dark:text-gray-400 group-hover:text-indigo-600">
                                                        Upload Image</p>
                                                </div>
                                                <input type="file" name="slim[]"
                                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"/>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Category and Name Row --}}
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <!-- Category -->
                                        <div class="space-y-2">
                                            <label for="category"
                                                   class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Category
                                                <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <select name="category" id="category" required
                                                        class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-0 transition-all duration-200 appearance-none @error('category') border-red-500 @enderror">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option
                                                            value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div
                                                    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                    <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20"
                                                         fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            @error('category')
                                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Shoe Name -->
                                        <div class="space-y-2">
                                            <label for="name"
                                                   class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Product Name
                                                <span class="text-red-500">*</span>
                                            </label>
                                            <input name="name" id="name" required value="{{ old('name') }}"
                                                   placeholder="Enter product name"
                                                   class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-0 transition-all duration-200 @error('name') border-red-500 @enderror">
                                            @error('name')
                                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Price and Description Row --}}
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <!-- Price -->
                                        <div class="space-y-2">
                                            <label for="price"
                                                   class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Price (KSH)
                                                <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span
                                                        class="text-gray-500 dark:text-gray-400 font-medium">KSH</span>
                                                </div>
                                                <input placeholder="1,700" type="number" name="price" id="price"
                                                       required value="{{ old('price') }}"
                                                       class="w-full pl-14 pr-4 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-0 transition-all duration-200 @error('price') border-red-500 @enderror">
                                            </div>
                                            @error('price')
                                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="space-y-2">
                                            <label for="description"
                                                   class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Description
                                                <span class="text-red-500">*</span>
                                            </label>
                                            <textarea name="description" id="description" rows="4" required
                                                      placeholder="Describe your product..."
                                                      class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-0 transition-all duration-200 resize-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                            @error('description')
                                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Sizes and Colors Row --}}
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                        <!-- Shoe Sizes -->
                                        <div class="space-y-4">
                                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Available
                                                Sizes</h3>
                                            @php
                                                $shoe_sizes = range(30, 45);
                                                $chunks = array_chunk($shoe_sizes, 4);
                                            @endphp
                                            <div class="grid grid-cols-2 gap-4">
                                                @foreach ($chunks as $chunk)
                                                    <div class="space-y-3">
                                                        @foreach ($chunk as $size)
                                                            <label
                                                                class="flex items-center space-x-3 cursor-pointer group">
                                                                <input type="checkbox" name="sizes[]"
                                                                       value="{{ $size }}"
                                                                       {{ is_array(old('sizes')) && in_array($size, old('sizes')) ? 'checked' : '' }}
                                                                       class="w-5 h-5 text-indigo-600 border-2 border-gray-300 rounded-md focus:ring-indigo-500 focus:ring-2 focus:ring-offset-0 transition-all duration-200">
                                                                <span
                                                                    class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 transition-colors duration-200">Size {{ $size }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Available Colors -->
                                        <div class="space-y-4">
                                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Available
                                                Colors</h3>
                                            @php
                                                $colors = [
                                                    'Black', 'Brown', 'Red', 'Blue', 'Yellow', 'White', 'Green', 'Orange',
                                                    'Grey', 'Beige', 'Tan', 'Pink', 'Purple', 'Maroon', 'Navy', 'Olive',
                                                    'Gold', 'Silver', 'Burgundy', 'Turquoise'
                                                ];
                                                $colorChunks = array_chunk($colors, 5);
                                            @endphp
                                            <div class="grid grid-cols-2 gap-4 max-h-48 overflow-y-auto pr-2">
                                                @foreach ($colorChunks as $chunk)
                                                    <div class="space-y-3">
                                                        @foreach ($chunk as $color)
                                                            <label
                                                                class="flex items-center space-x-3 cursor-pointer group">
                                                                <input type="checkbox" name="colors[]"
                                                                       value="{{ strtolower($color) }}"
                                                                       {{ is_array(old('colors')) && in_array(strtolower($color), old('colors')) ? 'checked' : '' }}
                                                                       class="w-5 h-5 text-indigo-600 border-2 border-gray-300 rounded-md focus:ring-indigo-500 focus:ring-2 focus:ring-offset-0 transition-all duration-200">
                                                                <span
                                                                    class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 transition-colors duration-200">{{ $color }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('colors')
                                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>



                                    <!-- Submit Button -->
                                    <div class="flex justify-end pt-4">
                                        <button type="submit"
                                                class="px-8 py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-indigo-500/50">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <span>Add Product</span>
                                    </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
            </flux:modal>


            <flux:modal.trigger name="edit-profile" class="md:w-96">
                <flux:button>Add product</flux:button>
            </flux:modal.trigger>

            {{-- Products Table --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div
                    class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 px-8 py-6 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Product Inventory</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your product catalog</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                #
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Product
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Stock
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                SKU
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($products as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div
                                        class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600 dark:text-green-400">
                                        KSh {{ number_format($product->price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $product->stock }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                            {{ $product->sku }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $product->is_active ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('products.edit', $product->id) }}"
                                           class="inline-flex items-center px-3 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg transition-colors duration-200 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        <button
                                            class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="space-y-3">
                                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                  d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 009.586 13H7"/>
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">No products
                                            found</h3>
                                        <p class="text-gray-500 dark:text-gray-400">Start by adding your first product
                                            using the form above.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if($products->hasPages())
                    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 flex justify-between sm:hidden">
                                @if ($products->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $products->previousPageUrl() }}"
                                       class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-gray-300">
                                        Previous
                                    </a>
                                @endif

                                @if ($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}"
                                       class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-gray-300">
                                        Next
                                    </a>
                                @else
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        Next
                                    </span>
                                @endif
                            </div>

                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-5">
                                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }}
                                        of {{ $products->total() }} results
                                    </p>
                                </div>
                                <div>
                                    {{ $products->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
