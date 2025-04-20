<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex flex-col gap-4">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Categories</h2>

                    {{-- Create Button --}}
                    <a href="{{ route('categories.create') }}" style="background: black"
                       class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition">
                        + Create Category
                    </a>
                </div>
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

        {{-- Categories Table --}}
        <div
            class="relative h-full flex-1 overflow-x-auto rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800 p-4">
            <table
                class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700 text-sm text-left text-gray-800 dark:text-gray-300">
                <thead
                    class="bg-gray-100 dark:bg-zinc-900 text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Parent</th>
                    <th scope="col" class="px-6 py-3">Type</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                @forelse ($categories as $index => $category)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                        <td class="px-6 py-3">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-white">{{ $category->name }}</td>
                        <td class="px-6 py-3">{{ $category->parent?->name ?? '—' }}</td>
                        <td class="px-6 py-3">
                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold
                        {{ $category->parent_id ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                        {{ $category->parent_id ? 'Subcategory' : 'Parent Category' }}
                    </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                            No categories found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>
</x-layouts.app>
