<?php

namespace Azuriom\Plugin\Support\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Plugin\Support\Models\Category;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Requests\TicketRequest;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $closed = $request->has('closed');
        $tickets = Ticket::with(['category', 'author'])
            ->tap(fn (Builder $query) => $closed
                ? $query->whereNotNull('closed_at')
                : $query->whereNull('closed_at')
            )
            ->with('comment.author')
            ->latest('updated_at')
            ->paginate();

        return view('support::admin.tickets.index', [
            'scheduler' => function_exists('scheduler_running') && scheduler_running(),
            'closed' => $closed,
            'tickets' => $tickets,
            'homeMessage' => setting('support.home', ''),
            'ticketsDelay' => setting('support.tickets_delay', 60),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('support::admin.tickets.show', [
            'ticket' => $ticket->load(['author', 'comments.author']),
            'categories' => Category::all(),
            'pendingId' => old('pending_id', Str::uuid()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        $ticket->update(Arr::except($request->validated(), 'content'));

        return to_route('support.admin.tickets.show', $ticket)
            ->with('success', trans('messages.status.success'));
    }

    public function open(Ticket $ticket)
    {
        $ticket->closed_at = null;
        $ticket->save();

        return to_route('support.admin.tickets.show', $ticket)
            ->with('success', trans('messages.status.success'));
    }

    public function close(Ticket $ticket)
    {
        $ticket->closed_at = now();
        $ticket->save();

        ActionLog::log('support-tickets.closed', $ticket);

        return to_route('support.admin.tickets.show', $ticket)
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return to_route('support.admin.tickets.index')
            ->with('success', trans('messages.status.success'));
    }
}
