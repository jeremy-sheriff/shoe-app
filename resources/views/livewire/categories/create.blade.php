<x-layouts.app :title="__('Create Category')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Add New Category</h2>


                </div>
            </div>

            {{-- Optional placeholders --}}
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

        {{-- Footer or extra section --}}
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <form action="{{ route('categories.store') }}" method="POST"
                  class="w-full max-w-xl  p-6 bg-white dark:bg-zinc-800 rounded-2xl space-y-6">
                @csrf

                {{-- Title --}}
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Create a New Category</h2>

                {{-- Name --}}
                <div>
                    <label for="name" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Category
                        Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="e.g. Sneakers, Boots"
                        class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
                    >
                    @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Parent Category --}}
                <div>
                    <label for="parent_id" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Parent
                        Category <span class="text-gray-400">(optional)</span></label>
                    <select
                        name="parent_id"
                        id="parent_id"
                        class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
                    >
                        <option value="">-- None --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit" style="background: black"
                            class="w-full inline-flex justify-center items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl shadow-md transition-all">
                        + Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>




