@extends('layouts.app')

@section('title', trans('support::messages.tickets.open'))

@section('content')
    <div class="container content">
        <h1>{{ trans('support::messages.tickets.open') }}</h1>

        <form action="{{ route('support.tickets.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="subjectInput">{{ trans('support::messages.fields.subject') }}</label>
                <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subjectInput" name="subject" value="{{ old('subject', $category->subject ?? '') }}" required>

                @error('subject')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
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

            <div class="mb-3">
                <label class="form-label" for="contentInput">{{ trans('messages.fields.content') }}</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="contentInput" name="content" rows="5" required>{{ old('content', $category->content ?? '') }}</textarea>

                @error('content')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> {{ trans('messages.actions.send') }}
            </button>
        </form>
    </div>
@endsection
