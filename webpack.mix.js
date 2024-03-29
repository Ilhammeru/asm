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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/regex.js', 'public/js')
    .js('resources/js/auth.js', 'public/js')
    .js('resources/js/unit.js', 'public/js')
    .js('resources/js/categories.js', 'public/js')
    .js('resources/js/division.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps()
    .setPublicPath('public')
    .version();
