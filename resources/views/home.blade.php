@extends('layouts.dashboard')

@section('content')

@push( 'scripts' )
    @include( 'components.head.tinymce-config' )
@endpush

<div class="card">
    <div class="card-header">{{ __('Dashboard') }}</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        {{ __('You are logged in!') }}
        @method( 'DELETE' )
    </div>
</div>

@endsection
