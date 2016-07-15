var elixir = require('laravel-elixir');

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

elixir(function (mix) {

    mix.sass('main.scss', 'public/assets/css/main.min.css');

    mix.scripts([
        'main/dropdown.js',
        'main/modal.js',
        'main/outdatedBrowser.js',
        'main/toolbar.js',
        'main/uiTooltip.js',
        'main/slimScroll.js',
        'main/tabs.js',
        'main/search.js',
        'main/button.js',
        'main/layout.js',
        'main/general.js',
        'main/feed.js',
        'main/form.js',
        'main/sticky.js'
    ], 'public/assets/js/main.min.js');

    // Individual Loaded JS
    mix.scripts('partials/slider.js', 'public/assets/js/partials/slider.min.js');

    // AJAX JS
    mix.scripts('api-feed.js', 'public/assets/js/api-feed.min.js');
    mix.scripts('api-notifications.js', 'public/assets/js/api-notifications.min.js');

    mix.copy('resources/assets/js/libs/outdatedbrowser.min.js', 'public/assets/js/libs/outdatedbrowser.min.js');
    mix.copy('resources/assets/js/libs/jquery-1.11.3.min.js', 'public/assets/js/libs/jquery-1.11.3.min.js');
    mix.copy('resources/assets/js/libs/mustache.min.js', 'public/assets/js/libs/mustache.min.js');
    mix.copy('resources/assets/js/libs/validator.min.js', 'public/assets/js/libs/validator.min.js');
    mix.copy('resources/assets/js/libs/jquery.slimscroll.min.js', 'public/assets/js/libs/jquery.slimscroll.min.js');
    mix.copy('resources/assets/js/libs/initial.min.js', 'public/assets/js/libs/initial.min.js');
    mix.copy('resources/assets/js/libs/bootstrap-customized.min.js', 'public/assets/js/libs/bootstrap-customized.min.js');

    /* mix.version([
     'assets/css/main.min.css',
     'assets/js/main.min.js'
     ]); */

});