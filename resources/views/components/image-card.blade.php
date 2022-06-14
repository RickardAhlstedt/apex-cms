<div class="col-2">
    <div class="card mb-3">
        <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
            <img src="{{ $image->getURL() }}" class="img-fluid"/>
            <a href="#!">
                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
            </a>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $image->name }}</h5>
            <p class="card-text">{{ $image->getSize() }}</p>
            <a href="{{ route( 'admin.images.show', $image->id ) }}" class="btn btn-primary">View</a>
            <form action="{{ route( 'admin.images.delete', $image->id ) }}" method="POST" class="d-inline" data-pjax-no-push="true">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-floating"><i class="fa fa-trash"></i></button>
            </form>
        </div>
    </div>
</div>
