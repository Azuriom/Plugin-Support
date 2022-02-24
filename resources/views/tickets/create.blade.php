@extends('layouts.app')

@section('title', trans('support::messages.tickets.open'))

@include('elements.markdown-editor')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1>{{ trans('support::messages.tickets.open') }}</h1>

            <div class="card">
                <div class="card-body">
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
                            <textarea class="form-control markdown-editor @error('content') is-invalid @enderror" id="contentInput" name="content" rows="5">{{ old('content', $category->content ?? '') }}</textarea>

                            @error('content')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> {{ trans('messages.actions.send') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
