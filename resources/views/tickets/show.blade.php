@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg p-6 space-y-4">
        <h1 class="text-2xl font-bold text-gray-800">Ticket #{{ $ticket->id }}</h1>

        <div>
            <h2 class="font-semibold text-gray-700">Title</h2>
            <p class="text-gray-800">{{ $ticket->title }}</p>
        </div>

        <div>
            <h2 class="font-semibold text-gray-700">Description</h2>
            <p class="text-gray-800">{{ $ticket->description }}</p>
        </div>

        <div class="flex space-x-6">
            <div>
                <h2 class="font-semibold text-gray-700">Status</h2>
                @if($ticket->status === 'open')
                    <span class="px-2 py-1 rounded bg-green-100 text-green-800">{{ $ticket->status_label }}</span>
                @elseif($ticket->status === 'in_progress')
                    <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">{{ $ticket->status_label }}</span>
                @else
                    <span class="px-2 py-1 rounded bg-red-100 text-red-800">{{ $ticket->status_label }}</span>
                @endif
            </div>

            <div>
                <h2 class="font-semibold text-gray-700">Priority</h2>
                @if($ticket->priority === 'low')
                    <span class="px-2 py-1 rounded bg-blue-100 text-blue-800">{{ $ticket->priority_label }}</span>
                @elseif($ticket->priority === 'medium')
                    <span class="px-2 py-1 rounded bg-orange-100 text-orange-800">{{ $ticket->priority_label }}</span>
                @else
                    <span class="px-2 py-1 rounded bg-red-100 text-red-800">{{ $ticket->priority_label }}</span>
                @endif
            </div>

            <div>
                <h2 class="font-semibold text-gray-700">Assigned Agent</h2>
                <p class="text-gray-800">{{ $ticket->agent?->name ?? 'Not Assigned' }}</p>
            </div>
        </div>

        <div class="flex justify-end space-x-2">
            @if(auth()->user()->isAdmin() || (auth()->user()->isAgent() && $ticket->agent_id == auth()->id()))
                <a href="{{ route('tickets.edit', $ticket) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">Edit</a>
            @endif
            <a href="{{ route('tickets.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">Back</a>
        </div>
    </div>
</div>
@endsection
