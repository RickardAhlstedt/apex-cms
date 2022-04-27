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
