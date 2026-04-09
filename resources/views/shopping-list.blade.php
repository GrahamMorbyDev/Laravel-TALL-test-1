@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Shopping List</h1>

    <form method="POST" action="{{ route('shopping-list.store') }}" class="mb-6 space-y-3">
        @csrf
        <div class="flex space-x-2">
            <input name="name" type="text" placeholder="Item name" required class="flex-1 border rounded px-3 py-2" />
            <input name="quantity" type="number" min="1" value="1" required class="w-24 border rounded px-3 py-2" />
            <select name="category" required class="border rounded px-3 py-2">
                <option value="">Select category</option>
                <option value="Fruit & Veg" {{ old('category') == 'Fruit & Veg' ? 'selected' : '' }}>Fruit & Veg</option>
                <option value="Dairy" {{ old('category') == 'Dairy' ? 'selected' : '' }}>Dairy</option>
                <option value="Frozen" {{ old('category') == 'Frozen' ? 'selected' : '' }}>Frozen</option>
                <option value="Bakery" {{ old('category') == 'Bakery' ? 'selected' : '' }}>Bakery</option>
                <option value="Household" {{ old('category') == 'Household' ? 'selected' : '' }}>Household</option>
                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Add</button>
        </div>
        <div>
            <input name="notes" type="text" placeholder="Notes (optional)" class="w-full border rounded px-3 py-2" />
        </div>
    </form>

    {{-- Filters: status + category (integrated, no separate page) --}}
    <form method="GET" action="{{ route('shopping-list.index') }}" class="mb-4" x-data>
        <div class="flex items-center space-x-3">
            <div class="flex rounded overflow-hidden border bg-white">
                <button type="submit" name="status" value="" class="px-3 py-2 text-sm {{ request('status') === null || request('status') === '' ? 'bg-indigo-600 text-white' : 'text-gray-700' }}">All</button>
                <button type="submit" name="status" value="active" class="px-3 py-2 text-sm {{ request('status') === 'active' ? 'bg-indigo-600 text-white' : 'text-gray-700' }}">Active</button>
                <button type="submit" name="status" value="completed" class="px-3 py-2 text-sm {{ request('status') === 'completed' ? 'bg-indigo-600 text-white' : 'text-gray-700' }}">Completed</button>
            </div>

            <div>
                <select name="category" @change="$el.form.submit()" class="border rounded px-3 py-2 text-sm">
                    <option value="">All Categories</option>
                    <option value="Fruit & Veg" {{ request('category') == 'Fruit & Veg' ? 'selected' : '' }}>Fruit & Veg</option>
                    <option value="Dairy" {{ request('category') == 'Dairy' ? 'selected' : '' }}>Dairy</option>
                    <option value="Frozen" {{ request('category') == 'Frozen' ? 'selected' : '' }}>Frozen</option>
                    <option value="Bakery" {{ request('category') == 'Bakery' ? 'selected' : '' }}>Bakery</option>
                    <option value="Household" {{ request('category') == 'Household' ? 'selected' : '' }}>Household</option>
                    <option value="Other" {{ request('category') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="text-sm text-gray-500">
                @if(request('status') || request('category'))
                    <span>Showing</span>
                    @if(request('status') === 'active')<span class="font-medium"> active </span>@elseif(request('status') === 'completed')<span class="font-medium"> completed </span>@else<span class="font-medium"> all </span>@endif
                    @if(request('category'))
                        <span>items in</span> <span class="font-medium">{{ request('category') }}</span>
                    @endif
                @else
                    <span>Showing all items</span>
                @endif
            </div>
        </div>
    </form>

    <ul class="divide-y">
        @forelse($items as $item)
            <li class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-3">
                    <form method="POST" action="{{ route('shopping-list.update', $item) }}"
                          x-data="{ completed: {{ $item->is_completed ? 'true' : 'false' }}, loading: false, action: '{{ route('shopping-list.update', $item) }}', async send() { loading = true; try { const res = await fetch(this.action, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ is_completed: this.completed ? 1 : 0, _method: 'PATCH' }) }); if (!res.ok) throw new Error('Network'); } catch (e) { this.completed = !this.completed; alert('Unable to update item.'); } finally { loading = false; } } }"
                          @submit.prevent>
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="is_completed" :value="completed ? 1 : 0" />
                        <input id="toggle-{{ $item->id }}" type="checkbox" :checked="completed" x-model="completed" @change="send()" :disabled="loading" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                    </form>

                    <div class="min-w-0">
                        <div class="flex items-baseline space-x-2">
                            <span class="font-medium {{ $item->is_completed ? 'line-through text-gray-400' : '' }}" :class="completed ? 'line-through text-gray-400' : ''">{{ $item->name }}</span>
                            <span class="text-sm text-gray-500">x{{ $item->quantity }}</span>
                            @if($item->category)
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $item->category }}</span>
                            @endif
                        </div>
                        @if($item->notes)
                            <div class="text-sm {{ $item->is_completed ? 'text-gray-400' : 'text-gray-600' }}" :class="completed ? 'text-gray-400' : 'text-gray-600'">{{ $item->notes }}</div>
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
        @empty
            <li class="py-6 text-center text-gray-500">No items found.</li>
        @endforelse
    </ul>
</div>
@endsection
