@extends('admin.layouts.admin')

@section('title', trans('support::admin.title'))

@section('content')

    @can('support.categories')
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    {{ trans('support::admin.settings.title') }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('support.admin.settings.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="webhookInput">{{ trans('support::admin.settings.webhook') }}</label>
                        <input type="text" class="form-control @error('webhook') is-invalid @enderror" id="webhookInput" name="webhook" placeholder="https://discord.com/api/webhooks/.../..." value="{{ old('webhook', setting('support.webhook')) }}" aria-describedby="webhookInfo">

                        @error('webhook')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <small id="webhookInfo" class="form-text">{{ trans('support::admin.settings.webhook_info') }}</small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> {{ trans('messages.actions.update') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    {{ trans('support::admin.categories.title') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('messages.fields.name') }}</th>
                            <th scope="col">{{ trans('messages.fields.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($categories as $category)
                            <tr>
                                <th scope="row">{{ $category->id }}</th>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="{{ route('support.admin.categories.edit', $category) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-bs-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                                    <a href="{{ route('support.admin.categories.destroy', $category) }}" class="mx-1" title="{{ trans('messages.actions.delete') }}" data-bs-toggle="tooltip" data-confirm="delete"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                <a class="btn btn-primary" href="{{ route('support.admin.categories.create') }}">
                    <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
                </a>
            </div>
        </div>
    @endcan

    <div class="card shadow mb-4" id="tickets">
        <div class="card-header">
            <h5 class="card-title mb-0">
                {{ trans('support::admin.tickets.title') }}
            </h5>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if(!$closed) active @endif" href="{{ route('support.admin.tickets.index') }}#tickets" role="tab">
                        {{ trans('support::messages.state.open') }}
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if($closed) active @endif" href="{{ route('support.admin.tickets.index') }}?closed#tickets" role="tab">
                        {{ trans('support::messages.state.closed') }}
                    </a>
                </li>
            </ul>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('support::messages.fields.subject') }}</th>
                        <th scope="col">{{ trans('messages.fields.author') }}</th>
                        <th scope="col">{{ trans('messages.fields.status') }}</th>
                        <th scope="col">{{ trans('support::messages.fields.category') }}</th>
                        <th scope="col">{{ trans('messages.fields.date') }}</th>
                        <th scope="col">{{ trans('messages.fields.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($tickets as $ticket)
                        <tr>
                            <th scope="row">{{ $ticket->id }}</th>
                            <td>{{ $ticket->subject }}</td>
                            <td>{{ $ticket->author->name }}</td>
                            <td>
                                <span class="badge bg-{{ $ticket->isClosed() ? 'danger' : 'success' }}">
                                    {{ $ticket->statusMessage() }}
                                </span>
                            </td>
                            <td>{{ $ticket->category->name }}</td>
                            <td>{{ format_date_compact($ticket->created_at) }}</td>
                            <td>
                                <a href="{{ route('support.admin.tickets.show', $ticket) }}" class="mx-1" title="{{ trans('messages.actions.show') }}" data-bs-toggle="tooltip"><i class="bi bi-eye"></i></a>
                                @if($ticket->isClosed())
                                    <a href="{{ route('support.admin.tickets.destroy', $ticket) }}" class="mx-1" title="{{ trans('messages.actions.delete') }}" data-bs-toggle="tooltip" data-confirm="delete"><i class="bi bi-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            {{ $tickets->withQueryString()->links() }}
        </div>
    </div>
@endsection
