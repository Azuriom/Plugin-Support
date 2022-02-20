@extends('layouts.app')

@section('title', $ticket->subject)

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
                <img class="flex-shrink-0 me-3 rounded" src="{{ $comment->author->getAvatar() }}" alt="{{ $comment->author->name }}" height="55">
                <div class="flex-grow-1">
                    <div class="content-body">
                        <p class="mb-1 small">
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
            <i class="fas fa-info-circle"></i> {{ trans('support::messages.tickets.closed') }}
        </div>
    @else
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('support.tickets.comments.store', $ticket) }}" method="POST" class="mb-2">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="content">{{ trans('support::messages.fields.comment') }}</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4" required>{{ old('content') }}</textarea>
                    </div>

                    @error('content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-comment"></i> {{ trans('messages.actions.comment') }}
                    </button>
                </form>

                <form action="{{ route('support.tickets.close', $ticket) }}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban"></i> {{ trans('support::messages.actions.close') }}
                    </button>
                </form>
            </div>
        </div>
    @endif
@endsection
