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
       require('tailwindcss'),
   ]);

// Si estás utilizando React o Vue, puedes descomentar y ajustar las siguientes líneas:
// mix.react('resources/js/app.jsx', 'public/js');
// mix.vue('resources/js/app.js', 'public/js', { version: 2 });

if (mix.inProduction()) {
    mix.version();
}
