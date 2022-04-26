@php
    $aErrors = Session::get( 'error' );
    $aInfo = Session::get( 'info' );
    $aWarnings = Session::get( 'warning' );
    $aSuccess = Session::get( 'success' );
@endphp

@if( $aErrors ) @foreach ($aErrors as $sKey => $sValue)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ $sValue }}
         <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
    </div>
@endforeach @endif

@if( $aSuccess ) @foreach ($aSuccess as $sKey => $sValue)
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ $sValue }}
         <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
    </div>
@endforeach @endif

@if( $aInfo ) @foreach ($aInfo as $sKey => $sValue)
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Info!</strong> {{ $sValue }}
         <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
    </div>
@endforeach @endif

@if( $aWarnings ) @foreach ($aWarnings as $sKey => $sValue)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> {{ $sValue }}
         <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
    </div>
@endforeach @endif
