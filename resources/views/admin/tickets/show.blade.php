@extends('admin.layouts.admin')

@section('title', trans('support::admin.tickets.show', ['ticket' => $ticket->id, 'name' => $ticket->subject]))

@include('elements.markdown-editor', [
    'imagesUploadUrl' => route('support.admin.comments.attachments.pending', $pendingId),
])

@section('content')
    <div class="card shadow-sm mb-3">
        <div class="card-body">
             <span class="badge bg-{{ $ticket->isClosed() ? 'danger' : 'success' }}">
                 {{ $ticket->statusMessage() }}
             </span>
            @lang('support::messages.tickets.info', ['author' => e($ticket->author->name), 'category' => e($ticket->category->name), 'date' => format_date($ticket->created_at)])
        </div>
    </div>

    @foreach($ticket->comments as $comment)
        <div class="card shadow-sm mb-3">
            <div class="card-header @if($ticket->author->is($comment->author)) text-primary @else text-info @endif">
                @lang('messages.comments.author', ['user' => e($comment->author->name), 'date' => format_date($comment->created_at, true)])
            </div>
            <div class="card-body d-flex">
                <div class="flex-shrink-0">
                    <img class="me-3 rounded" src="{{ $comment->author->getAvatar() }}" alt="{{ $comment->author->name }}" width="55">
                </div>
                <div class="flex-grow-1">
                    <div class="content-body">
                        {{ $comment->parseContent() }}
                    </div>
                    <a href="{{ route('support.admin.tickets.comments.destroy', [$ticket, $comment]) }}" class="btn btn-danger" title="{{ trans('messages.actions.delete') }}" data-bs-toggle="tooltip" data-confirm="delete">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </div>
        </div>
    @endforeach

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            @if($ticket->isClosed())
                <p class="text-danger">
                    <i class="bi bi-x-lg"></i> {{ trans('support::messages.tickets.closed') }}
                </p>

                <form action="{{ route('support.admin.tickets.open', $ticket) }}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-arrow-repeat"></i> {{ trans('support::messages.actions.reopen') }}
                    </button>

                    <a href="{{ route('support.admin.tickets.destroy', $ticket) }}" class="btn btn-danger" data-confirm="delete"><i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}</a>
                </form>
            @else
                <form action="{{ route('support.admin.tickets.comments.store', $ticket) }}" method="POST" class="mb-2">
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

                <form action="{{ route('support.admin.tickets.close', $ticket) }}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-lg"></i> {{ trans('support::messages.actions.close') }}
                    </button>
                </form>
            @endif

        </div>
    </div>
@endsection
