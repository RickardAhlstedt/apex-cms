<div class="blockrow row" id="block-{block-count}">
    <div class="form-outline">
        <input type="text" class="block-title form-control" name="block-{block-count}-title">
        <label for="block-{block-count}-title" class="form-label">Title</label>
    </div>
    <div class="blockrow">
        <textarea id="blocks[]" class="block-content-{block-count} block" data-type="code" data-count="{block-count}"></textarea>
        <div class="blockTools mt-3 right-align">
            <button type="button" class="btn btn-primary btn-floating my-2 add-block" data-mdb-toggle="modal" data-mdb-target="#blockModal">
                <i class="fas fa-plus"></i>
            </button>
            <a href="#" class="btn btn-danger btn-floating remove-block" data-target="block-{block-count}"><i class="fas fa-trash"></i></a>
        </div>
    </div>
</div>
