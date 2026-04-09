<div class="bg-white shadow rounded-lg p-6">
    <form wire:submit.prevent="addItem" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" wire:model.defer="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Apples">
                @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" wire:model.defer="quantity" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('quantity') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Notes (optional)</label>
            <textarea wire:model.defer="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Add any notes..."></textarea>
            @error('notes') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Add Item</button>
        </div>
    </form>

    <hr class="my-6">

    <div>
        <h2 class="text-lg font-medium text-gray-900 mb-4">Items</h2>

        <div class="space-y-3">
            @forelse($items as $item)
                <div class="flex items-start justify-between p-4 border rounded-lg">
                    <div>
                        <div class="flex items-baseline space-x-3">
                            <h3 class="text-md font-semibold">{{ $item->name }}</h3>
                            <span class="text-sm text-gray-500">× {{ $item->quantity }}</span>
                        </div>
                        @if($item->notes)
                            <p class="text-sm text-gray-600 mt-1">{{ $item->notes }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-2">Added {{ $item->created_at->diffForHumans() }}</p>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button onclick="confirm('Delete this item?') || event.stopImmediatePropagation()" wire:click="deleteItem({{ $item->id }})" class="inline-flex items-center px-3 py-1.5 bg-red-50 border border-red-200 text-red-700 rounded-md text-sm hover:bg-red-100">Delete</button>
                    </div>
                </div>
            @empty
                <div class="text-sm text-gray-500">No items yet. Add your first shopping item above.</div>
            @endforelse
        </div>
    </div>
</div>
