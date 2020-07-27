<?php

namespace Azuriom\Plugin\Support\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Support\Models\Category;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Requests\TicketRequest;
use Illuminate\Support\Arr;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('support::admin.tickets.index', [
            'tickets' => Ticket::with(['category', 'author'])->paginate(),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return view('support::admin.tickets.show', [
            'ticket' => $ticket->load(['author', 'comments.author']),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Azuriom\Plugin\Support\Requests\TicketRequest  $request
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        $ticket->update(Arr::except($request->validated(), 'content'));

        return redirect()->route('support.admin.tickets.show', $ticket)
            ->with('success', trans('support::admin.tickets.status.updated'));
    }

    public function open(Ticket $ticket)
    {
        $ticket->closed_at = null;
        $ticket->save();

        return redirect()->route('support.admin.tickets.show', $ticket)
            ->with('success', trans('support::admin.tickets.status.opened'));
    }

    public function close(Ticket $ticket)
    {
        $ticket->closed_at = now();
        $ticket->save();

        return redirect()->route('support.admin.tickets.show', $ticket)
            ->with('success', trans('support::admin.tickets.status.closed'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('support.admin.tickets.index')
            ->with('success', trans('support::admin.tickets.status.deleted'));
    }
}
