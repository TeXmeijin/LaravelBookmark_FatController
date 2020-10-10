const mix = require('laravel-mix');
const glob = require('glob');

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
    .sass('resources/sass/app.scss', 'public/css')

// @see https://qiita.com/katsunory/items/3585ab8072d74d234302
glob.sync('resources/sass/page/*.scss').map(function(file) {
  mix.sass(file, 'public/css/page');
});
glob.sync('resources/sass/components/*.scss').map(function(file) {
  mix.sass(file, 'public/css/components');
});