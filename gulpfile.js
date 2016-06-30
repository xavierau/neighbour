var elixir = require('laravel-elixir');

require('laravel-elixir-vueify');
require('laravel-elixir-webpack');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass([
        'app.scss',
        "../../../node_modules/toastr/toastr.scss"
    ])
        .browserify('app.js')
        .browserify('dashboard/app.js', 'public/js/dashboard.js');
});
