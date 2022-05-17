@extends( 'layouts.dashboard' )

@section( 'title' ) {{ $pageTitle }} @endsection

@section( 'body_class' ) create_posts @endsection

@push( 'scripts' )
    @include( 'components.head.tinymce-config', [ 'class' => 'blockContent' ] )
@endpush

@section( 'content' )

<form action="{{ route( 'admin.posts.store' ) }}" method="POST">
    @csrf

    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-9">
                <div class="card mb-3">
                    <div class="card-header">
                        {{ $pageTitle }}
                    </div>
                    <div class="card-body">
                        <div class="form-outline mb-3">
                            <input type="text" class="form-control" id="title" name="title">
                            <label for="title" class="form-label">Title</label>
                        </div>

                        <div id="blocks">
                            {{-- Tiny and block-controller --}}
                            <div class="blockTemplate d-none">
                                <textarea id="block[]" class="block-content"></textarea>
                                <div class="blockTools mt-3 right-align">
                                    <a href="#" class="btn btn-primary btn-floating mx-2 addBlock"><i class="fas fa-plus"></i></a>
                                    <a href="#" class="btn btn-danger btn-floating removeBlock"><i class="fas fa-trash"></i></a>
                                </div>
                            </div>

                            <div class="genesis">
                                @include( 'components.forms.tinymce-editor', [ 'id' => 'blocks[]', 'content' => '', 'class' => 'blockContent' ] )
                                <div class="blockTools mt-3 right-align">
                                    <a href="#" class="btn btn-primary btn-floating mx-2 addBlock"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col col-md-3">
                <div class="card">
                    <div class="card-header">
                        Settings
                    </div>
                    <div class="card-body">
                        <div class="form-outline mb-3">
                            <select class="form-control active" id="status" name="status">
                                <option value="draft" selected="selected">Draft</option>
                                <option value="published">Published</option>
                            </select>
                            <label for="status" class="form-label">Status</label>
                        </div>

                        <button class="btn btn-primary" type="submit">Save</button>

                        {{-- Separator --}}
                        <hr>
                        {{-- Meta --}}
                        <div class="form-group">
                            <div class="form-outline mb-3">
                                <input type="text" class="form-control" id="seo_title" name="seo_title">
                                <label for="seo_title" class="form-label">Meta Title</label>
                            </div>
                            <div class="form-outline mb-3">
                                <textarea class="form-control" id="seo_description" name="seo_description"></textarea>
                                <label for="seo_description" class="form-label">Meta description</label>
                            </div>
                            <div class="form-outline mb-3">
                                <input type="text" class="form-control" id="seo_keywords" name="seo_keywords">
                                <label for="seo_keywords" class="form-label">Meta keywords</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
