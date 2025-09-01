<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $tickets = $user->myTickets()->with('agent')->get();

        } elseif ($user->isAgent()) {
            $tickets = $user->assignedTickets()->with('admin')->get();

        } else {
            $tickets = $user->tickets()->with('admin', 'agent')->get();
        }

        return view('tickets.index', compact('tickets'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agents = User::where('role', 'agent')->get();
        $admins = User::where('role', 'admin')->get();
        return view('tickets.create', compact('agents','admins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $user = Auth::user();

        $adminId = $user->isAdmin() ? $user->id : null;

        Ticket::create([
            'user_id' => $user->id,
            'admin_id' => $request->validated()['admin_id'] ?? ($user->isAdmin() ? $user->id : null),
            'title' => $request->validated()['title'],
            'description' => $request->validated()['description'],
            'priority' => $request->validated()['priority'],
            'status' => 'open',
            'agent_id' => $request->validated()['agent_id'] ?? null,
        ]);


        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $user = Auth::user();
        $agents = User::where('role', 'agent')->get();
        if ($user->isAdmin()) {
            $agents = User::where('role', 'agent')->get();
        } else {
            $agents = collect();
        }

        return view('tickets.edit', compact('ticket', 'agents'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $user = auth()->user();

        if ($user->isAdmin() && $ticket->admin_id === $user->id) {
            $ticket->update($request->validated());

        } elseif ($user->isAgent() && $ticket->agent_id === $user->id) {
            $ticket->update([
                'status' => $request->validated()['status'] ?? $ticket->status,
            ]);

        } elseif ($user->isUser() && $ticket->user_id === $user->id) {
            $ticket->update(array_filter($request->validated(), function($key) {
                return in_array($key, ['title','description','priority']);
            }, ARRAY_FILTER_USE_KEY));

        } else {
            abort(403, 'Unauthorized');
        }

        return redirect()->route('tickets.show', $ticket)
                         ->with('success', 'Ticket updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}