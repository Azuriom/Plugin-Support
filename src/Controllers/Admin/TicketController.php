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
        $closed = $request->input('status') === 'closed';
        $assignFilter = $request->input('assign', 'all');
        $tickets = Ticket::with(['category', 'author', 'assignee'])
            ->tap(fn (Builder $query) => $closed
                ? $query->whereNotNull('closed_at')
                : $query->whereNull('closed_at')
            )
            ->when($assignFilter !== 'all', fn (Builder $query) => $assignFilter === 'self'
                ? $query->where('assignee_id', $request->user()->id)
                : $query->whereNull('assignee_id')
            )
            ->with('comment.author')
            ->withMax('comments', 'created_at')
            ->latest('comments_max_created_at')
            ->paginate();

        return view('support::admin.tickets.index', [
            'scheduler' => function_exists('scheduler_running') && scheduler_running(),
            'assignFilter' => $assignFilter,
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
        $ticket->update(Arr::only($request->validated(), 'subject'));

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

    public function assign(Request $request, Ticket $ticket)
    {
        $ticket->assignee()->associate($request->user());
        $ticket->save();

        return to_route('support.admin.tickets.show', $ticket)
            ->with('success', trans('messages.status.success'));
    }

    public function unassign(Ticket $ticket)
    {
        $ticket->assignee()->dissociate();
        $ticket->save();

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
