@extends('layouts.app')

@section('title', trans('support::messages.tickets.open'))

@if($category->fields->isEmpty())
    @include('elements.markdown-editor', [
        'imagesUploadUrl' => route('support.comments.attachments.pending', $pendingId),
        'autosaveId' => 'support_ticket',
    ])
@endif

@section('content')
    <h1>{{ trans('support::messages.tickets.open') }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('support.category.tickets.store', $category) }}" method="POST">
                @csrf

                <input type="hidden" name="pending_id" value="{{ $pendingId }}">

                <div class="mb-3">
                    <label class="form-label" for="subjectInput">{{ trans('support::messages.fields.subject') }}</label>
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subjectInput" name="subject" value="{{ old('subject', $category->subject ?? '') }}" required>

                    @error('subject')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                @if($category->fields->isEmpty())
                    <div class="mb-3">
                        <label class="form-label" for="contentInput">{{ trans('messages.fields.content') }}</label>
                        <textarea class="form-control markdown-editor @error('content') is-invalid @enderror" id="contentInput" name="content" rows="5">{{ old('content', $category->content ?? '') }}</textarea>
    
                        @error('content')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                @else
                    @foreach($category->fields as $field)
                        @if($field->type === 'checkbox')
                            <div class="form-check mb-3">
                                <input class="form-check-input @error($field->inputName()) is-invalid @enderror"
                                       type="checkbox"
                                       name="{{ $field->inputName() }}"
                                       id="{{ $field->inputName() }}"
                                        @required($field->is_required)
                                        @checked(old($field->inputName()))
                                >

                                <label class="form-check-label" for="{{ $field->inputName() }}">
                                    {{ $field->name }}
                                    @if($field->is_required)
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>

                                @error($field->inputName())
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                @if($field->description)
                                    <div class="form-text">
                                        {{ $field->description }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="{{ $field->inputName() }}" class="form-label">
                                    {{ $field->name }}
                                    @if($field->is_required)
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>

                                @if($field->type === 'dropdown')
                                    <select class="form-select @error($field->inputName()) is-invalid @enderror"
                                            name="{{ $field->inputName() }}"
                                            id="{{ $field->inputName() }}"
                                            @required($field->is_required)
                                    >
                                        @foreach($field->options as $option)
                                            <option @selected(old($field->inputName()) === $option)>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                @elseif($field->type === 'textarea')
                                    <textarea class="form-control @error($field->inputName()) is-invalid @enderror"
                                              name="{{ $field->inputName() }}"
                                              id="{{ $field->inputName() }}"
                                              rows="3"
                                              @required($field->is_required)
                                    >{{ old($field->inputName()) }}</textarea>
                                @else
                                        <input type="{{ $field->type }}"
                                               class="form-control @error($field->inputName()) is-invalid @enderror"
                                               name="{{ $field->inputName() }}" id="{{ $field->inputName() }}"
                                               value="{{ old($field->inputName()) }}"
                                               @required($field->is_required)
                                        >
                                @endif

                                @error($field->inputName())
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                @if($field->description)
                                    <div class="form-text">
                                        {{ $field->description }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                @endif

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send"></i> {{ trans('messages.actions.send') }}
                </button>
            </form>
        </div>
    </div>
@endsection
