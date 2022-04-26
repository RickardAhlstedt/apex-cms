<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

use App\Models as models;

class FormRenderProvider extends ServiceProvider
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
    public function boot()
    {
        Blade::directive('form', function ( string $model) {
            $aModels = config( 'form.classes' );
            if( !array_key_exists( $model, $aModels ) ) {
                return "<br /><b>ERROR: Model $model wasn't found in the configuration-file, please make sure that the model is there</b>";
            }

            $sModel = $aModels[ $model ];
            $oModel = new $sModel();

            $aFields = $oModel->getDictionary();
            $aParams = $oModel->getDictionaryParams();
            // Instantiate the render
            $oRender = new \App\Render\Form($aFields, $aParams);
            // Render the form
            return $oRender->render();
        });
    }
}
