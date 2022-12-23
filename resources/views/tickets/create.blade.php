@extends('layouts.app')

@section('title', trans('support::messages.tickets.open'))

@include('elements.markdown-editor', [
    'imagesUploadUrl' => route('support.comments.attachments.pending', $pendingId),
    'autosaveId' => 'support_ticket',
])

@section('content')
    <h1>{{ trans('support::messages.tickets.open') }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('support.tickets.store') }}" method="POST">
                @csrf

                <input type="hidden" name="pending_id" value="{{ $pendingId }}">

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="subjectInput">{{ trans('support::messages.fields.subject') }}</label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subjectInput" name="subject" value="{{ old('subject', $category->subject ?? '') }}" required>

                        @error('subject')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="categorySelect">{{ trans('support::messages.fields.category') }}</label>

                        <select class="form-select" id="categorySelect" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') === $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        @error('category_id')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="contentInput">{{ trans('messages.fields.content') }}</label>
                    <textarea class="form-control markdown-editor @error('content') is-invalid @enderror" id="contentInput" name="content" rows="5">{{ old('content', $category->content ?? '') }}</textarea>

                    @error('content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> {{ trans('messages.actions.send') }}
                </button>
            </form>
        </div>
    </div>
@endsection
