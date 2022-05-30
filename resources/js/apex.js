jQuery( function( $ ) {
    $(document).pjax('[data-pjax], a[data-pjax]', '#content');

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
        } );
        // Close the modal
        $(this).closest(".modal").modal("hide");
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
