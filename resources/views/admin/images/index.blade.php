@extends( 'layouts.dashboard' )

@section( 'title' ) {{ $pageTitle }} @endsection

@section( 'body_class' ) images_grid @endsection

@section( 'content' )

@php
    $aSuccessUpload = Session::get( 'success' );
    $aErrorsUpload = Session::get( 'error' );
@endphp

@if( $aErrorsUpload ) @foreach ($aErrorsUpload as $sKey => $sValue)
    <script type="text/javascript">
        window.notify( window.Notifications.ERROR, null, '{{ $sValue }}', false );
    </script>
@endforeach @endif

@if( $aSuccessUpload ) @foreach ($aSuccessUpload as $sKey => $sValue)
    <script type="text/javascript">
        window.notify( window.Notifications.SUCCESS, null, '{{ $sValue }}', true );
    </script>
@endforeach @endif

<div class="container-fluid">
    <div class="row">
        <div class="col col-md-10">
            {{-- Images card and grid --}}
            <div class="card">
                <div class="card-header">
                    {{ $pageTitle }}
                </div>
                <div class="card-body">
                    {{-- @include( 'components.dropzone' ) --}}
                    <form action="{{ route('admin.images.index' ) }}" method="GET" role="form" data-pjax="true">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" placeholder="Search" aria-label="Search" id="search" name="search" value="{{ $_GET['search'] ?? '' }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        {{-- Images grid --}}
                        @foreach( $images as $image )
                            @include( 'components.image-card', [
                                'image' => $image
                            ] )
                        @endforeach

                    </div>
                    {{ $images->links() }}
                </div>
            </div>
        </div>
        <div class="col col-md-2">
            <div class="card mb-3">
                <div class="card-header">
                    Upload
                </div>
                <div class="card-body">
                    <form action="" method="POST" class="image-upload" id="image-upload" enctype="multipart/form-data" data-pjax="true">
                        @csrf
                        <div class="form-group">
                            <label for="image">Upload image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/png,image/jpg,image/jpeg,image/gif">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Folders (EXPERIMENTAL)
                </div>
                <div class="card-body">
                    {{-- Toolbar for refreshing this fragment and adding folder --}}
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm" data-mdb-toggle="modal" data-mdb-target="#addFolderModal">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm folder-sync">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                    {{-- Folders list --}}
                    <div class="list-group mt-3" id="folders-list">
                        @foreach( $folders as $folder )
                            <a href="{{ route( 'admin.images.index', [ 'folder' => $folder->name ] ) }}" class="">
                                <i class="fas fa-folder"></i>
                                {{ $folder->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Modals --}}
<div class="modal fade" id="addFolderModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Create folder</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col col-md-12">
                        <form method="POST" class="add-folder">
                            <div class="form-outline mb-3">
                                <input type="text" class="form-control" id="folder_name" name="folder_name">
                                <label for="folder_name" class="form-label">Folder name</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
