@extends( 'layouts.dashboard' )

@section( 'title' ) {{ $pageTitle }} @endsection

@section( 'content' )

<div class="container-fluid">
    <div class="row">
        <div class="col col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ $pageTitle }}
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.posts' ) }}" method="GET" role="form" data-pjax="true">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" placeholder="Search" aria-label="Search" id="search" name="search" value="{{ $_GET['search'] ?? '' }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                    <table class="table" role="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $posts as $post )
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->author->name }}</td>
                                    <td>{{ ucfirst($post->status) }}</td>
                                    <td>{{ $post->created_at }}</td>
                                    <td>{{ $post->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.posts', $post->id ) }}" class="btn btn-primary btn-floating mx-2"><i class="fas fa-pen"></i></a>
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
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
