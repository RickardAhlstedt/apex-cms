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

    $("body#admin.create_posts").on( 'click', 'a.addBlock', function(e) {
        window.cloneBlock( $, e );
    } );

    $("body#admin.create_posts").on( 'click', '.block a.removeBlock', function(e) {
        // Remove the block
        $(this).parent().parent().remove();
    } );

} );

window.cloneBlock = function ( $, e ) {
    e.preventDefault();
    // Get the block-count
    var blockCount = $(".block").length;
    console.log( blockCount );
    // Copy the element with class blockTemplate
    $(".blockTemplate").clone().appendTo("#blocks").removeClass("d-none").removeClass("blockTemplate").addClass("block mb-3").attr("id", "block-" + blockCount);
    // Make sure that tiny is can be initialized for the new block
    var res = tinymce.init( {
        selector: '#block-' + blockCount + ' .block-content',
        plugins: 'code table lists',
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
