<?php

use Illuminate\Support\Facades\Cache;

if( !function_exists( 'menu' ) ) {
    function menu( $sGroup = 'guest', $depth = 0, $parent = 0 ) {
        $oRender = new \App\Render\Menu();

        if( $sMenu = Cache::get( 'menu_' . $sGroup . '_' . $depth . '_' . $parent ) ) {
            // $sMenu = Cache::get( 'menu_' . $sGroup . '_' . $depth . '_' . $parent );
            echo $sMenu;
            return;
        } else {
            ob_start();
            $oRender->buildMenu( $parent, $depth, $sGroup );
            $sMenu = ob_get_clean();

            Cache::put( 'menu_' . $sGroup . '_' . $depth . '_' . $parent, $sMenu );
        }

        echo $sMenu;
        return;
    }
}
