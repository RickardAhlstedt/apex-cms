const { default: axios } = require("axios");

jQuery( function( $ ) {
    $(document).pjax('[data-pjax], a[data-pjax]', '#content');

    $(document).on( 'submit', 'form[data-pjax-no-push]', function(event) {
        $.pjax.submit(event, '#content', { push: false } )
    } );

    $(document).on( 'submit', 'form[data-pjax]', function(event) {
        $.pjax.submit(event, '#content')
    } );

    $("#loader").css( "top", ($("#main-navbar").outerHeight()) + "px" );

    $("#loader").slideUp();
    $(document).on( 'pjax:send', function() {
        $('#loader').slideDown()
    } );
    $(document).on( 'pjax:complete', function() {
        $('#loader').slideUp()
        $(".form-outline").each( function() {
            new mdb.Input($(this)[0]).init();
        } );
    } );

    $("body#admin.images_edit a.delete-image").on( "click", function(e) {
        e.preventDefault();
        var target = $(this).data('target');

        var form = $("form" + target);
        form.submit();
    } );

    $("body#admin.create_posts form.create-post").one( "submit", function( e ) {
        e.preventDefault();
        var form = $(this);

        // Get all the blocks by id blocks[]
        var blocks = [];
        $(".block").each( function( index, element ) {
            var block = {};
            block.id = $(element).attr("data-count");
            block.type = $(element).attr("data-type");
            // block.content = $(this).summernote("code");
            blocks.push(block);
        } );

        // Insert a json-array of blocks into the form
        $("input#blocktypes").val( JSON.stringify( blocks ) );
        console.log(JSON.stringify( blocks ));
        // Submit the form
        // form.submit();
    } );

    $("body#admin a.sidenav-link").on( 'click', function(e) {
        $("body#admin a.sidenav-link.active").removeClass("active");
        $(this).addClass("active");
    } );

    $("body#admin.create_posts").on( 'click', 'a.inject-block', function(e) {
        e.preventDefault();
        let type = $(this).data("block");
        let target = $(this).data("target");

        // Get the block-count
        let blockCount = $(".block").length;

        // Fetch the block template with axios
        axios.get( "/api/v1/admin/blocks/template/" + type ).then( function( response ) {
            let template = response.data;

            console.log( "Got template: " + template );

            // Replace the placeholder with the block count
            template = template.replace( /{block-count}/g, blockCount );

            // Append the template to the target
            $(target).append( template );
            console.log( "Appended template to target" );
            if( type == "text" ) {
                window.addEditor( "#blocks-" + blockCount );
            }
            if( type == "code" ) {

            }
        } );
        // Close the modal
        $(this).closest(".modal").modal("hide");
    } );

    $("body#admin.images_grid form.add-folder").on( "submit", function(e) {
        e.preventDefault();
        let form = $(this);

        axios.post( "/api/v1/admin/images/folders", form.serialize() ).then( function( response ) {
            console.log( response );
            if( response.data.success ) {
                notify( "success", "Success", "Folder created" );
            } else {
                notify( "error", "Error", response.data.message );
            }
        } ).catch( error => {
            notify( "error", "Error", error.response.data.message );
        } );
    } );

    $("body#admin.images_grid button.folder-sync").on( "click", function(e) {
        axios.get( "/api/v1/admin/images/folders" ).then( function( response ) {
            console.log( response );
            if( response.data.success ) {
                notify( "success", "Success", "Folders synced" );
                // Get all the folders from the response, and build a list
                let folders = response.data.folders;
                let list = "";
                for( let i = 0; i < folders.length; i++ ) {
                    list += "<a href='/admin/images?folder=" + folders[i].name + "'><i class='fas fa-folder'></i> " + folders[i].name + "</a>";
                }
                // Replace the list with the new list
                $("#folders-list").html( list );
            }
        } );
    } );

    $("body#admin.create_posts").on( 'click', 'a.remove-block', function(e) {
        e.preventDefault();
        let target = $(this).data("target");
        console.log(target);
        $("#" + target).remove();
    } );

} );

window.addEditor = function( id ) {
    ClassicEditor.create( document.querySelector(id), {
        removePlugins: ['EasyImage']
    } ).catch( error => { console.log( error ) });
}

window.Notifications = {
    SUCCESS: "success",
    WARNING: "warning",
    ERROR: "error"
};

window.notify = function ( type = "success", title = null, message = "", autoclose = true ) {
    new Notify ({
        status: type,
        title: title,
        text: message,
        effect: 'slide',
        speed: 300,
        customClass: '',
        customIcon: '',
        showIcon: true,
        showCloseButton: true,
        autoclose: autoclose,
        autotimeout: 3000,
        gap: 20,
        distance: 20,
        type: 3,
        position: 'right top'
    } );
}
