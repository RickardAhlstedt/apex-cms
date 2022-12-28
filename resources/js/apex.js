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

    $("body#admin a.sidenav-link").on( 'click', function(e) {
        $("body#admin a.sidenav-link.active").removeClass("active");
        $(this).addClass("active");
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

} );

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
