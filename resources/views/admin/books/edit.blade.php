@extends('layouts.dashboard')

@section( 'title' ) {{ $pageTitle }} @endsection

@section( 'content' )

<form action="" method="POST" role="form">
@method( 'PUT' )
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <div class="card">
                    <div class="card-header">{{ __( 'app.book_details' ) }}</div>
                    <div class="card-body">
                        <div class="form-outline mb-3">
                            <input type="text" id="name" name="name" class="form-control" value="{{ $book->name }}"/>
                            <label class="form-label" for="name">{{ __('app.book_name') }}</label>
                        </div>
                        <div class="form-outline mb-3">
                            <textarea class="form-control" id="description" name="description" rows="4">{{ $book->description }}</textarea>
                            <label class="form-label" for="description">{{ __('app.book_description') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('app.your_contacts' ) }}</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('app.book_name') }}</th>
                                    <th scope="col">{{ __( 'app.book.phone' ) }}</th>
                                    <th scope="col">{{ __( 'app.book.email' ) }}</th>
                                    <th scope="col">{{ __( 'app.created' ) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_contacts as $oContact )
                                    <tr>
                                        <th scope="row">{{ $oContact->name }}</th>
                                        <td>{{ $oContact->phone }}</td>
                                        <td>{{ $oContact->email }}</td>
                                        <td>{{ $oContact->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
