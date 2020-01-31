@extends('admin.layouts.admin')

@section('title', trans('support::admin.categories.title-create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('support.admin.categories.store') }}" method="POST">

                @include('support::admin.categories._form')

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ trans('messages.actions.save') }}</button>
            </form>
        </div>
    </div>
@endsection
