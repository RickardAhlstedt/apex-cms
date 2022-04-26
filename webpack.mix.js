const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
    .js('resources/js/mdb.min.js', 'public/js');
mix.copyDirectory('vendor/tinymce/tinymce', 'public/js/tinymce');
// // Copy all the files from the resources/js/ to the public/js/
// mix.copyDirectory('resources/js/', 'public/js/');
// // Copy all the files from the resources/css/ to the public/css/
// mix.copyDirectory('resources/css/', 'public/css/');
// // Copy all the files from the resources/images/ to the public/images/
mix.copyDirectory('resources/images/', 'public/images/');


