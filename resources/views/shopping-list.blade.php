@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Shopping List</h1>

    <div>
        @livewireStyles
        <livewire:shopping-list />
        @livewireScripts
    </div>
</div>
@endsection
