<?php

if( !function_exists( 'menu' ) ) {
    function menu( $sGroup = 'guest', $depth = 0, $parent = 0 ) {
        $oRender = new \App\Render\Menu();
        return $oRender->buildMenu( $parent, $depth, $sGroup );
    }
}
