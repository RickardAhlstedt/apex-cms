@php
    $aErrors = Session::get( 'error' );
    $aInfo = Session::get( 'info' );
    $aWarnings = Session::get( 'warning' );
    $aSuccess = Session::get( 'success' );
@endphp

@if( $aErrors ) @foreach ($aErrors as $sKey => $sValue)
    @push( 'scripts' )
    <script type="text/javascript">
        window.notify( window.Notifications.ERROR, null, '{{ $sValue }}', false );
    </script>
    @endpush
@endforeach @endif

@if( $aSuccess ) @foreach ($aSuccess as $sKey => $sValue)
    @push( 'scripts' )
        <script type="text/javascript">
            window.notify( window.Notifications.SUCCESS, null, '{{ $sValue }}', true );
        </script>
    @endpush
@endforeach @endif

@if( $aInfo ) @foreach ($aInfo as $sKey => $sValue)
    @push( 'scripts' )
        <script type="text/javascript">
            window.notify( window.Notifications.WARNING, null, '{{ $sValue }}', false );
        </script>
    @endpush
@endforeach @endif

@if( $aWarnings ) @foreach ($aWarnings as $sKey => $sValue)
    @push( 'scripts' )
        <script type="text/javascript">
            window.notify( window.Notifications.WARNING, null, '{{ $sValue }}', false );
        </script>
    @endpush
@endforeach @endif
