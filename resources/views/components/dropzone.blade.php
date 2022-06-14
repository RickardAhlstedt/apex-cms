@push( 'styles' )
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
@endpush
@push( 'scripts' )
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

<script type="text/javascript">
    Dropzone.options.imageUpload = {
            maxFilesize: 1,
            acceptedFiles: ".jpeg,.jpg,.png,.gif"
        };
</script>

@endpush

<div class="container mt-3">
    <div class="row">
        <div class="col col-md-12">
            <form action="{{ route('admin.images.upload') }}" method="POST" enctype="multipart/form-data" id="image-upload" class="dropzone">
                @csrf
            </form>
        </div>
    </div>
</div>

