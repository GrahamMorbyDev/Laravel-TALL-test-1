@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-2xl font-semibold mb-6">Shopping List</h1>

    @if(session('success'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded p-6 mb-8">
        <form action="{{ route('shopping.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" required class="mt-1 block w-full border border-gray-300 rounded px-3 py-2" />
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="quantity" min="1" value="1" required class="mt-1 block w-32 border border-gray-300 rounded px-3 py-2" />
                @error('quantity') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Notes (optional)</label>
                <textarea name="notes" rows="3" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"></textarea>
                @error('notes') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Add Item</button>
            </div>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($items as $item)
            <div class="bg-white shadow rounded p-4 flex justify-between items-start">
                <div>
                    <div class="text-lg font-medium">{{ $item->name }} <span class="text-sm text-gray-500">× {{ $item->quantity }}</span></div>
                    @if($item->notes)
                        <div class="text-sm text-gray-600 mt-1">{{ $item->notes }}</div>
                    @endif
                    <div class="text-xs text-gray-400 mt-2">Added {{ $item->created_at->diffForHumans() }}</div>
                </div>
                <div>
                    <form action="{{ route('shopping.destroy', $item) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-gray-600">No items yet. Add something above.</div>
        @endforelse
    </div>
</div>
@endsection
