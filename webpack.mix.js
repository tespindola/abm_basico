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

 mix.browserSync('http://localhost:8000/');

 mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
 

 mix.webpackConfig({
     resolve: {
         extensions: ['.js', '.vue'],
         // Definimos atajos los cuales nos ahorran tener que escribir rutas completas
         alias: {
             '@': __dirname + '/resources/js', // carpeta general
             '@c': __dirname + '/resources/js/components', // carpeta components
             '@cl': __dirname + '/resources/js/components/layouts', // carpeta layouts
             '@v': __dirname + '/resources/js/views', // carpeta para las views
             '@s': __dirname + '/resources/js/server', // carpeta para la configuracion de servidor axios
             '@r': __dirname + '/resources/js/router', // carpeta para vue router
         }
     }
});

// deshabilita las notificaciones build (exitosas) durante watch (npm run watch)
mix.disableSuccessNotifications();
 