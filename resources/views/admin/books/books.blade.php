@extends('layouts.dashboard')

@section( 'title' ) {{ $pageTitle }} @endsection

@section( 'content' )

<div class="container-fluid">
    <div class="row">
        <div class="col col-md-12">
            <div class="card">
                <div class="card-header">{{ $pageTitle }}</div>
                <div class="card-body">
                    <form action="{{ route('admin.books' ) }}" method="GET" role="form" data-pjax="true">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" placeholder="{{ __('app.search') }}" aria-label="Search" id="search" name="search" value="{{ $_GET['search'] ?? '' }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">{{ __('app.search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <table role="table" class="table">
                    <thead>
                        <tr>
                            <th>{{ __('app.book_name')}}</th>
                            <th>{{ __('app.book_description') }}</th>
                            @if( $user->role == 'admin' )
                                <th>{{ __( 'app.book_created_by' ) }}</th>
                            @endif
                            <th>{{ __( 'app.created' ) }}</th>
                            <th>{{ __( 'app.updated' ) }}</th>
                            <th>{{ __( 'app.actions' ) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $books as $book )
                            <tr>
                                <td>{{ $book->name }}</td>
                                <td>{{ $book->description }}</td>
                                @if( $user->role == 'admin' )
                                    <td>{{ $book->owner->first()->name }}</td>
                                @endif
                                <td>{{ $book->created_at }}</td>
                                <td>{{ $book->updated_at }}</td>
                                <td>
                                    <a href="{{ route('admin.books.edit', $book->id ) }}" class="btn btn-primary btn-floating mx-2"><i class="fas fa-pen"></i></a>
                                    <form action="" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-floating"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $books->links() }}
        </div>
    </div>
</div>

@endsection
