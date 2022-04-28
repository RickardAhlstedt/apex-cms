<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

use App\Models\Menu\Menu;

class MenuRenderProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        Blade::directive( 'menu', function( $arguments ) {
            $oRender = new \App\Render\Menu();
            return "<?php menu( " . $arguments . " ); ?>";
        } );
    }
}
