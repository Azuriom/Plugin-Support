@extends('layouts.app')

@section('title', trans('support::messages.title'))

@section('content')
    <h1>{{ trans('support::messages.title') }}</h1>

    @if($infoText !== null)
        <div class="card mb-4">
            <div class="card-body pb-0">
                {{ $infoText }}
            </div>
        </div>
    @endif

    <div class="card" id="support">
        <div class="card-body">
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <th scope="col">{{ trans('support::messages.fields.subject') }}</th>
                    <th scope="col">{{ trans('support::messages.fields.category') }}</th>
                    <th scope="col">{{ trans('messages.fields.status') }}</th>
                    <th scope="col">{{ trans('messages.fields.date') }}</th>
                </tr>
                </thead>
                <tbody>

                @foreach($tickets as $ticket)
                    <tr>
                        <td>
                            <a href="{{ route('support.tickets.show', $ticket) }}">{{ $ticket->subject }}</a>
                        </td>
                        <td>{{ $ticket->category->name }}</td>
                        <td>
                        <span class="badge bg-{{ $ticket->isClosed() ? 'danger' : 'success' }}">
                            {{ $ticket->statusMessage() }}
                        </span>
                        </td>
                        <td>{{ format_date_compact($ticket->created_at) }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            <a href="{{ route('support.tickets.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> {{ trans('support::messages.actions.create') }}
            </a>
        </div>
    </div>
@endsection
