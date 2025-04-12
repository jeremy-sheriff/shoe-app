<x-layouts.app :title="__('Dashboard')">
    <div class="flex flex-col gap-6 h-full w-full">

        {{-- Top Section with Form and Empty Right Side --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Left: Product Form --}}
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 bg-white dark:bg-zinc-800 h-fit">
                <form wire:submit.prevent="save" class="space-y-4">
                    <x-input label="Name" wire:model.defer="name" />
                    <x-textarea label="Description" wire:model.defer="description" />

                    <div class="flex flex-col md:flex-row gap-4">
                        <x-input label="Price" type="number" wire:model.defer="price" class="w-full" />
                        <x-input label="Stock" type="number" wire:model.defer="stock" class="w-full" />
                    </div>

                    <x-input label="SKU" wire:model.defer="sku" />

                    <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">
                        <select wire:model.defer="status"
                                class="input w-full rounded-md border dark:bg-zinc-800 dark:border-zinc-600">
                            <option value="active">Active</option>
                            <option value="draft">Draft</option>
                            <option value="archived">Archived</option>
                        </select>

                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model.defer="is_active" />
                            Active
                        </label>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showModal', false)"
                                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 dark:bg-zinc-700 dark:text-white">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>

            {{-- Right: Empty Section --}}
            <div class="rounded-xl border border-dashed border-neutral-300 dark:border-neutral-700 p-6 bg-white dark:bg-zinc-800 flex items-center justify-center">
                <span class="text-zinc-400 dark:text-zinc-500">Empty space – for preview, image, stats, etc.</span>
            </div>
        </div>

        {{-- Full-width Product Table --}}
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 bg-white dark:bg-zinc-800 w-full">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">Products</h2>
            </div>

            <div class="overflow-x-auto border border-zinc-200 dark:border-zinc-700 rounded-lg">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700 text-sm text-left">
                    <thead class="bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-200 uppercase tracking-wide text-xs">
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
                                <a href="{{ route('products.create', $product) }}" class="text-blue-600 hover:underline">Edit</a>
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
