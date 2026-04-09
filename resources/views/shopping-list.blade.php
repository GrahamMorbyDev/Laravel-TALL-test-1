@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
  <h1 class="text-2xl font-semibold mb-6">Shopping List</h1>

  @if(session('success'))
    <div class="mb-4 text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 p-3 rounded">
      <ul class="list-disc pl-5 text-sm text-red-700">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('shopping-list.store') }}" method="POST" class="mb-8 bg-white shadow-sm rounded p-4">
    @csrf
    <div class="grid grid-cols-3 gap-4">
      <div class="col-span-2">
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Quantity</label>
        <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
      </div>

      <div class="col-span-3">
        <label class="block text-sm font-medium text-gray-700">Notes (optional)</label>
        <textarea name="notes" class="mt-1 block w-full rounded border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
      </div>
    </div>

    <div class="mt-4">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Add Item</button>
    </div>
  </form>

  <div class="space-y-3">
    @forelse($items as $item)
      <div class="flex items-center justify-between bg-white p-4 rounded shadow-sm">
        <div>
          <div class="font-medium">{{ $item->name }} <span class="text-gray-500">x{{ $item->quantity }}</span></div>
          @if($item->notes)
            <div class="text-sm text-gray-600 mt-1">{{ $item->notes }}</div>
          @endif
        </div>
        <div class="flex items-center">
          <form action="{{ route('shopping-list.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this item?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
          </form>
        </div>
      </div>
    @empty
      <div class="text-gray-600">No items yet. Add one above.</div>
    @endforelse
  </div>
</div>
@endsection
