@extends( 'layouts.dashboard' )

@section( 'title' ) {{ $pageTitle }} @endsection

@section( 'body_class' ) images_edit @endsection

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
        <div class="col col-md-9">
            <div class="card">
                <div class="card-header">
                    {{ $pageTitle }}
                </div>
                <div class="card-body">
                    <img src="{{ $image->getURL() }}" class="img-fluid"/>
                </div>
            </div>
        </div>
        <div class="col col-md-3">
            <div class="card">
                <div class="card-header">
                    Details
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.images.update', $image->id) }}" method="POST" data-pjax="true">
                        @csrf
                        <div class="form-outline mb-3">
                            <input type="text" name="name" id="name" class="form-control active" value="{{ $image->name }}">
                            <label for="name" class="form-label">Name</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    <hr />
                    <p class="fw-lighter">Size: {{ $image->getSize() }}</p>
                    <p class="fw-lighter">Folder: {{ $image->folder }}</p>
                    <p class="fw-lighter">Extension: {{ $image->extension }}</p>
                    <p class="fw-lighter">Mime: {{ $image->mime }}</p>
                    <p class="fw-lighter">Created: {{ $image->created_at }}</p>
                    <p class="fw-lighter">Updated: {{ $image->updated_at }}</p>
                    <hr />
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.images.index') }}">
                                <i class="fas fa-arrow-left"></i>&nbsp;Back
                            </a>
                            <a class="btn btn-primary btn-sm" href="{{ $image->getURL() }}" target="_blank">
                                <i class="fas fa-external-link-alt"></i>&nbsp;View
                            </a>
                            <a class="btn btn-danger btn-sm delete-image" data-target=".image-delete">
                                <i class="fas fa-trash"></i>&nbsp;Delete
                            </a>
                        </div>
                    </div>
                    <form action="{{ route( 'admin.images.delete', $image->id ) }}" method="POST" data-pjax-no-push="true" class="d-none image-delete">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
