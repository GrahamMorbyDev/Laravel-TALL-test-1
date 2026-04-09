@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Shopping List</h1>

    <form method="POST" action="{{ route('shopping-list.store') }}" class="mb-6 space-y-3">
        @csrf
        <div class="flex space-x-2">
            <input name="name" type="text" placeholder="Item name" required class="flex-1 border rounded px-3 py-2" />
            <input name="quantity" type="number" min="1" value="1" required class="w-24 border rounded px-3 py-2" />
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Add</button>
        </div>
        <div>
            <input name="notes" type="text" placeholder="Notes (optional)" class="w-full border rounded px-3 py-2" />
        </div>
    </form>

    <ul class="divide-y">
        @foreach($items as $item)
            <li class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-3">
                    <form method="POST" action="{{ route('shopping-list.update', $item) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="is_completed" value="{{ $item->is_completed ? '0' : '1' }}" />
                        <input id="toggle-{{ $item->id }}" type="checkbox" {{ $item->is_completed ? 'checked' : '' }} onchange="this.form.submit()" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                    </form>

                    <div class="min-w-0">
                        <div class="flex items-baseline space-x-2">
                            <span class="font-medium {{ $item->is_completed ? 'line-through text-gray-400' : '' }}">{{ $item->name }}</span>
                            <span class="text-sm text-gray-500">x{{ $item->quantity }}</span>
                        </div>
                        @if($item->notes)
                            <div class="text-sm {{ $item->is_completed ? 'text-gray-400' : 'text-gray-600' }}">{{ $item->notes }}</div>
                        @endif
                    </div>
                </div>

                <div>
                    <form method="POST" action="{{ route('shopping-list.destroy', $item) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
