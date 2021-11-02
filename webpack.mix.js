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

// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);

mix.js('resources/js/web/main.js', 'public/js/web')
    .sass('resources/sass/web/main.scss', 'public/css/web')
    .js('resources/js/web/exam.js', 'public/js/web')
    .js('resources/js/web/start-exam.js', 'public/js/web')
    .sass('resources/sass/web/exam.scss', 'public/css/web')
    .sass('resources/sass/web/start-exam.scss', 'public/css/web')
    .js('resources/js/admin/main.js', 'public/js/admin')
    .sass('resources/sass/admin/main.scss', 'public/css/admin')
    .postCss('resources/css/guest.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .js('resources/js/guest.js', 'public/js')
    .react();

if (mix.inProduction()) {
    mix.version();
}
