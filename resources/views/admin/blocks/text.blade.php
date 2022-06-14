<div class="blockrow row" id="block-{block-count}">
    <input type="text" class="block-title" name="" value="">
    <div class="blockrow">
        <textarea id="blocks-{block-count}" class="block-content-{block-count} block" data-type="text" data-count="{block-count}" name="blocks[]"></textarea>
        <div class="blockTools">
            <button type="button" class="btn btn-primary btn-floating my-2 add-block" data-mdb-toggle="modal" data-mdb-target="#blockModal">
                <i class="fas fa-plus"></i>
            </button>
            <a href="#" class="btn btn-danger btn-floating remove-block" data-target="block-{block-count}"><i class="fas fa-trash"></i></a>
        </div>
    </div>
</div>
