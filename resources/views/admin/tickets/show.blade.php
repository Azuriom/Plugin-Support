@extends('admin.layouts.admin')

@section('title', trans('support::admin.tickets.title-show', ['ticket' => $ticket->id, 'name' => $ticket->subject]))

@section('content')
    <div class="card shadow-sm mb-3">
        <div class="card-body">
             <span class="badge badge-{{ $ticket->isClosed() ? 'danger' : 'success' }}">
                 {{ $ticket->statusMessage() }}
             </span>
            @lang('support::messages.tickets.status-info', ['author' => e($ticket->author->name), 'category' => e($ticket->category->name), 'date' => format_date($ticket->created_at)])
        </div>
    </div>

    @foreach($ticket->comments as $comment)
        <div class="card shadow-sm mb-3">
            <div class="card-header @if($ticket->author->is($comment->author)) text-primary @else text-info @endif">
                @lang('messages.comments.author', ['user' => e($comment->author->name), 'date' => format_date($comment->created_at, true)])
            </div>
            <div class="card-body media">
                <img class="d-flex mr-3 rounded" src="{{ $comment->author->getAvatar() }}" alt="{{ $comment->author->name }}" height="55">
                <div class="media-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="content-body">
                            {{ $comment->parseContent() }}
                        </div>
                        <a href="{{ route('support.admin.tickets.comments.destroy', [$ticket, $comment]) }}" class="btn btn-danger" title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip" data-confirm="delete"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            @if($ticket->isClosed())
                <p class="text-danger"><i class="fas fa-ban"></i> {{ trans('support::messages.tickets.closed') }}</p>

                <form action="{{ route('support.admin.tickets.open', $ticket) }}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i>
                        {{ trans('support::messages.actions.reopen') }}
                    </button>

                    <a href="{{ route('support.admin.tickets.destroy', $ticket) }}" class="btn btn-danger" data-confirm="delete"><i class="fas fa-trash"></i> {{ trans('messages.actions.delete') }}</a>
                </form>
            @else
                <form action="{{ route('support.admin.tickets.comments.store', $ticket) }}" method="POST" class="mb-2">
                    @csrf

                    <div class="form-group">
                        <label for="content">{{ trans('messages.comments.your-comment') }}</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4" required>{{ old('content') }}</textarea>
                    </div>

                    @error('content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-comment"></i>
                        {{ trans('messages.actions.comment') }}
                    </button>
                </form>

                <form action="{{ route('support.admin.tickets.close', $ticket) }}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban"></i>
                        {{ trans('support::messages.actions.close') }}
                    </button>
                </form>
            @endif

        </div>
    </div>
@endsection
