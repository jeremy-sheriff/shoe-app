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
                            <input value="{{$product->name}}" name="name" id="name" required
                                   class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white">
                        </div>
                    </div>


                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Price -->
                        <div class="w-full md:w-1/2 space-y-2">
                            <label for="price" class="block text-sm font-medium text-gray-800 dark:text-white">Price
                                (Ksh)</label>
                            <input value="{{$product->price}}" type="number" name="price" id="price" step="50" min="100" required
                                   class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Available colors -->
                        <div class="w-full md:w-1/2 space-y-2">
                            @foreach ($product->colors as $color)
                                <label class="flex items-center space-x-2 text-sm text-gray-700 dark:text-white">
                                    <input
                                        type="checkbox"
                                        name="colors[]"
                                        value="{{ strtolower($color) }}"
                                        class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary"
                                        {{ in_array(strtolower($color), old('colors', $product->colors ?? [])) ? 'checked' : '' }}
                                    >
                                    <span>{{ $color }}</span>
                                </label>
                            @endforeach

                        </div>
                    </div>

                    <!-- Description -->
                    <div class="w-full  space-y-2">
                        <label for="description" class="block text-sm font-medium text-gray-800 dark:text-white">Description</label>
                        <textarea name="description" id="description" rows="4" required
                                  class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            {{$product->description}}
                        </textarea>
                    </div>


                    <!-- Image Uploads -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-black mb-2">Upload
                            Images</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Image 1 -->
                            <div class="slim border-2 border-dashed rounded-lg p-4" data-label="Drop your image here"
                                 data-size="240,240" data-ratio="1:1">
                                <img src="{{ asset('storage/' . $product->images[0]->path) }}" alt="{{ $product->name }}">
                                <input type="file" name="slim[]" required/>
                            </div>
                            <!-- Image 2 -->
                            <div class="slim border-2 border-dashed rounded-lg p-4" data-size="240,240"
                                 data-ratio="1:1">
                                <img src="{{ asset('storage/' . $product->images[1]->path) }}" alt="{{ $product->name }}">
                                <input type="file" name="slim[]"/>
                            </div>
                            <!-- Image 3 -->
                            <div class="slim border-2 border-dashed rounded-lg p-4" data-size="240,240"
                                 data-ratio="1:1">
                                <img src="{{ asset('storage/' . $product->images[2]->path) }}" alt="{{ $product->name }}">
                                <input type="file" name="slim[]"/>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                                class="w-full sm:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow-sm transition duration-200 ease-in-out">
                            Update Product
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</x-layouts.app>
