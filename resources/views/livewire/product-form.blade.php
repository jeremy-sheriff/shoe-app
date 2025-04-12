<livewire:product-form>
<div>
    <button
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
        wire:click="create"
    >
        + Add Product
    </button>

    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl shadow-lg w-full max-w-lg">
                <h2 class="text-xl font-bold mb-4 text-zinc-800 dark:text-white">New Product</h2>

                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="block mb-1 text-sm">Name</label>
                        <input type="text" wire:model.defer="name" class="w-full input" />
                        @error('name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-sm">Description</label>
                        <textarea wire:model.defer="description" class="w-full input"></textarea>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block mb-1 text-sm">Price</label>
                            <input type="number" wire:model.defer="price" step="0.01" class="w-full input" />
                            @error('price') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex-1">
                            <label class="block mb-1 text-sm">Stock</label>
                            <input type="number" wire:model.defer="stock" class="w-full input" />
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm">SKU</label>
                        <input type="text" wire:model.defer="sku" class="w-full input" />
                        @error('sku') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block mb-1 text-sm">Status</label>
                            <select wire:model.defer="status" class="w-full input">
                                <option value="draft">Draft</option>
                                <option value="active">Active</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="checkbox" wire:model.defer="is_active" />
                            <label class="text-sm">Is Active</label>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4 space-x-2">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 dark:bg-zinc-700 dark:hover:bg-zinc-600">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
</livewire:product-form>
