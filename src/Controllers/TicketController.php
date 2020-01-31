<?php

namespace Azuriom\Plugin\Support\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Support\Models\Category;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Requests\TicketRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::where('author_id', Auth::id())->get();

        return view('support::tickets.index', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('support::tickets.create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Azuriom\Plugin\Support\Requests\TicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {
        $ticket = Ticket::create(Arr::except($request->validated(), 'content'));

        $ticket->comments()->create(Arr::only($request->validated(), 'content'));

        return redirect()->route('support.tickets.show', $ticket);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load('comments');

        return view('support::tickets.show', ['ticket' => $ticket]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Azuriom\Plugin\Support\Requests\TicketRequest  $request
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $ticket->update($request->validated());

        return view('support::tickets.show', $ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function close(Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $ticket->closed_at = now();
        $ticket->save();

        return redirect()->route('support.admin.tickets.show', $ticket)
            ->with('success', trans('support::admin.tickets.status.closed'));
    }
}
