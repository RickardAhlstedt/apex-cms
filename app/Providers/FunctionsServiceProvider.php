<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FunctionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->bootFunctions();
    }

    protected function bootFunctions() {
        foreach( glob(__DIR__ . '/../Functions/*.php') as $sFilename ) {
            require_once $sFilename;
        }
    }
}
