@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Ticket #{{ $ticket->id }}</h1>

    <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="bg-white shadow-md rounded-lg p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title', $ticket->title) }}" class="w-full border rounded px-3 py-2"
            @if(auth()->user()->isAgent()) disabled @endif required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Description</label>
            <textarea name="description" rows="5" class="w-full border rounded px-3 py-2"
            @if(auth()->user()->isAgent()) disabled @endif required>{{ old('description', $ticket->description) }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Priority</label>
            <select name="priority" class="w-full border rounded px-3 py-2" @if(auth()->user()->isAgent()) disabled @endif required>
                <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        @if(auth()->user()->isAdmin() || auth()->user()->isAgent())
        <div>
            <label class="block text-gray-700 font-medium mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2" required>
                <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>
        @endif

        @if(auth()->user()->isAdmin())
        <div>
            <label class="block text-gray-700 font-medium mb-1">Assign Agent</label>
            <select name="agent_id" class="w-full border rounded px-3 py-2">
                <option value="">Unassigned</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" {{ $ticket->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="flex justify-end space-x-2">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">Update</button>
            <a href="{{ route('tickets.show', $ticket) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">Cancel</a>
        </div>
    </form>
</div>
@endsection
