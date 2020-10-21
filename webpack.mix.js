const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles([
        'resources/vendor/css/all.min.css',
        'resources/vendor/css/adminlte.min.css',
    ], 'public/css/plantilla.css')
    .sass('resources/sass/app.scss', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .scripts([
        'resources/vendor/js/adminlte.min.js',
    ], 'public/js/plantilla.js')
    .copyDirectory('resources/vendor/fontawesome/webfonts', 'public/webfonts');

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');
