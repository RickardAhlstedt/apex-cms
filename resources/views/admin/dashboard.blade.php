@extends('layouts.dashboard')

@section('title', $pageTitle ?? 'Dashboard' )

@section('content')

@push( 'scripts' )
    @include( 'components.head.tinymce-config' )
@endpush

<div class="card">
    <div class="card-header">{{ __('Dashboard') }}</div>

    <div class="card-body">
        @menu( 'admin' )
    </div>
</div>

@endsection
