@extends('layouts.dashboard')

@section( 'title' ) {{ $pageTitle }} @endsection

@section( 'content' )

<div class="container-fluid">
    <div class="row">
        <div class="col col-md-2">
            <div class="card">
                <div class="card-header">
                    Filters
                </div>
                <div class="card-body">
                    <div class="list-group list-group-light" role="group" aria-label="User-tools">
                        <a data-pjax href="{{ route('admin.users.create') }}" class="list-group-item list-group-item-action px-3 border-0">Add user</a>
                        <a data-pjax href="{{ route('admin.users') }}" class="list-group-item list-group-item-action px-3 border-0">All users</a>
                        <a data-pjax href="{{ route('admin.users') }}?role=admin" class="list-group-item list-group-item-action px-3 border-0">Admins</a>
                        <a data-pjax href="{{ route('admin.users') }}?role=user" class="list-group-item list-group-item-action px-3 border-0">Users</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-md-10">
            <div class="card">
                <div class="card-header">{{ $pageTitle }}</div>
                <div class="card-body">
                    <form action="{{ route('admin.users' ) }}" method="GET" role="form" data-pjax="true">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" placeholder="Search" aria-label="Search" id="search" name="search" value="{{ $_GET['search'] ?? '' }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                    <table role="table" class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $users as $user )
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.users', $user->id ) }}" class="btn btn-primary btn-floating mx-2"><i class="fas fa-pen"></i></a>
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
                    {{ $users->links() }}
                </div>
        </div>
    </div>
</div>

@endsection
