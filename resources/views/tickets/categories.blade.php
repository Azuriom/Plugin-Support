@extends('layouts.app')

@section('title', trans('support::messages.tickets.open'))

@section('content')
    <h1>{{ trans('support::messages.tickets.open') }}</h1>

    @if($infoText !== null)
        <div class="card mb-4">
            <div class="card-body pb-0">
                {{ $infoText }}
            </div>
        </div>
    @endif

    <div class="card">
        <ul class="list-group list-group-flush">
            @foreach($categories as $category)
                <li class="list-group-item">
                    <div class="row justify-content-around">
                        <div class="col-md-8 align-self-center">
                            <div class="d-flex">
                                <div class="flex-shrink-0 align-self-center fs-1 text-primary">
                                    @if($category->icon)
                                        <i class="{{ $category->icon }}"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3 align-self-center">
                                    <h5 class="card-title mb-0">{{ $category->name }}</h5>

                                    @if($category->description)
                                        <p class="card-text mt-2 mb-0">{{ $category->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-auto align-self-center">
                            <a href="{{ route('support.category.tickets.create', $category) }}" class="btn btn-primary">
                                {{ trans('support::messages.actions.create') }}
                            </a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
