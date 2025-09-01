@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Create Ticket</h1>

@if(auth()->user()->isUser() || auth()->user()->isAdmin())
<form method="POST" action="{{ route('tickets.store') }}" class="bg-white shadow-md rounded-lg p-6 space-y-4">
    @csrf

    <div>
        <label class="block text-gray-700 font-medium mb-1">Title</label>
        <input type="text" name="title" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
    </div>

    <div>
        <label class="block text-gray-700 font-medium mb-1">Description</label>
        <textarea name="description" rows="5" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required></textarea>
    </div>

    <div>
        <label class="block text-gray-700 font-medium mb-1">Priority</label>
        <select name="priority" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>
    </div>

    @if(auth()->user()->isAdmin())
    <div>
        <label class="block text-gray-700 font-medium mb-1">Assign Agent</label>
        <select name="agent_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Unassigned</option>
            @foreach($agents as $agent)
                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    @if(auth()->user()->isUser())
    <div>
        <label class="block text-gray-700 font-medium mb-1">Select Admin</label>
        <select name="admin_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            <option value="">Select Admin</option>
            @foreach($admins as $admin)
                <option value="{{ $admin->id }}">{{ $admin->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    <div class="flex justify-end">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded shadow">
            Submit
        </button>
    </div>
</form>
@endif
</div>
@endsection
