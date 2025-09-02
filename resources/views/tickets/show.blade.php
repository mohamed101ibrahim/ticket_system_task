@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- Ticket Header --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $ticket->title }}</h1>
        <p class="text-gray-600 mb-4">{{ $ticket->description }}</p>

        <div class="flex flex-wrap gap-4 text-sm text-gray-700">
            <span><strong>Status:</strong>
                @if($ticket->status === 'open')
                    <span class="px-2 py-1 rounded bg-green-100 text-green-700">Open</span>
                @else
                    <span class="px-2 py-1 rounded bg-red-100 text-red-700">Closed</span>
                @endif
            </span>

            <span><strong>Priority:</strong> {{ ucfirst($ticket->priority) }}</span>

            @if($ticket->agent)
                <span><strong>Assigned Agent:</strong> {{ $ticket->agent->name }}</span>
            @else
                <span class="text-gray-500"><em>No agent assigned yet</em></span>
            @endif
        </div>
    </div>

    {{-- Conversation Section --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Conversation</h2>

        @forelse($ticket->replies as $reply)
            <div class="mb-4 p-4 rounded border
                {{ $reply->user->isAgent() ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }}">
                <div class="flex justify-between items-center mb-2">
                    <strong>{{ $reply->user->name }}</strong>
                    <small class="text-gray-500">{{ $reply->created_at->diffForHumans() }}</small>
                </div>
                <p class="text-gray-700">{{ $reply->message }}</p>
            </div>
        @empty
            <p class="text-gray-500">No replies yet. Be the first to reply.</p>
        @endforelse
    </div>

    {{-- Reply Form --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Post a Reply</h2>

        <form action="{{ route('tickets.replies.store', $ticket) }}" method="POST">
            @csrf
            <textarea name="message" rows="4" class="w-full border rounded p-2 mb-4" required></textarea>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                Send Reply
            </button>
        </form>
    </div>

</div>
@endsection
