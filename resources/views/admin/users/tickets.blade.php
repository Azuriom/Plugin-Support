<div class="table-responsive" id="tickets">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">{{ trans('support::messages.fields.subject') }}</th>
            <th scope="col">{{ trans('messages.fields.author') }}</th>
            <th scope="col">{{ trans('messages.fields.status') }}</th>
            <th scope="col">{{ trans('support::messages.fields.category') }}</th>
            <th scope="col">{{ trans('messages.fields.date') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach($tickets as $ticket)
            <tr>
                <td>
                    <a href="{{ route('support.admin.tickets.show', $ticket) }}">
                        {{ $ticket->subject }}
                    </a>
                </td>
                <td>{{ $ticket->author->name }}</td>
                <td>
                    <span class="badge bg-{{ $ticket->isClosed() ? 'danger' : 'success' }}">
                        {{ $ticket->statusMessage() }}
                    </span>
                </td>
                <td>{{ $ticket->category->name }}</td>
                <td>{{ format_date_compact($ticket->created_at) }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
