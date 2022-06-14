@extends('layouts.dashboard')

@section('title', $pageTitle ?? 'Dashboard' )

@section('content')

@push( 'scripts' )
@endpush

<div class="card">
    <div class="card-header">{{ __('Dashboard') }}</div>

    <div class="card-body">
        @menu( 'admin', 0, 0 )
    </div>
</div>

@endsection
