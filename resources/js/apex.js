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
                console.log( "Text block" );
                window.initTinyMCE( '.block-content-' + blockCount );
                console.log( "Done initializing tinymce" );
            }
        } );
    } );
} );

window.initTinyMCE = function ( selector ) {
    res = tinymce.init( {
        selector: selector,
        plugins: 'code table lists',
        toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    } );
    console.log( res );
}


window.cloneBlock = function ( $, e ) {
    e.preventDefault();
    // Get the block-count
    var blockCount = $(".block").length;
    console.log( blockCount );
    // Copy the element with class blockTemplate
    $(".blockTemplate").clone().appendTo("#blocks-list").removeClass("d-none").removeClass("blockTemplate").addClass("block mb-3").attr("id", "block-" + blockCount);
    // Make sure that tiny is can be initialized for the new block
    var res = tinymce.init( {
        selector: '#blocks-' + blockCount + ' .block-content',
        plugins: ['code', 'table', 'lists'],
        toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    } );
    console.log( res );
};
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
