@extends('layouts.app')

@section('title', $ticket->subject)

@include('elements.markdown-editor', [
    'imagesUploadUrl' => route('support.comments.attachments.pending', $pendingId),
    'autosaveId' => 'support_ticket_'.$ticket->id,
])

@section('content')
    <h1>{{ $ticket->subject }}</h1>

    <div class="card mb-3">
        <div class="card-body">
             <span class="badge bg-{{ $ticket->isClosed() ? 'danger' : 'success' }}">
                 {{ $ticket->statusMessage() }}
             </span>
            @lang('support::messages.tickets.info', ['author' => e($ticket->author->name), 'category' => e($ticket->category->name), 'date' => format_date($ticket->created_at)])
        </div>
    </div>

    @foreach($ticket->comments as $comment)
        <div class="card mb-3">
            <div class="card-body d-flex">
                <div class="flex-shrink-0">
                    <img class="me-3 rounded" src="{{ $comment->author->getAvatar() }}" alt="{{ $comment->author->name }}" width="55">
                </div>
                <div class="flex-grow-1">
                    <div class="content-body">
                        <p class="mb-1 small text-muted">
                            @lang('messages.comments.author', ['user' => e($comment->author->name), 'date' => format_date($comment->created_at, true)])
                        </p>

                        {{ $comment->parseContent() }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if($ticket->isClosed())
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> {{ trans('support::messages.tickets.closed') }}
        </div>
    @else
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('support.tickets.comments.store', $ticket) }}" method="POST" class="mb-2">
                    @csrf

                    <input type="hidden" name="pending_id" value="{{ $pendingId }}">

                    <div class="mb-3">
                        <label class="form-label" for="content">{{ trans('support::messages.fields.comment') }}</label>
                        <textarea class="form-control markdown-editor @error('content') is-invalid @enderror" id="content" name="content" rows="4">{{ old('content') }}</textarea>
                    </div>

                    @error('content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-chat"></i> {{ trans('messages.actions.comment') }}
                    </button>
                </form>

                <form action="{{ route('support.tickets.close', $ticket) }}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-lg"></i> {{ trans('support::messages.actions.close') }}
                    </button>
                </form>
            </div>
        </div>
    @endif
@endsection
