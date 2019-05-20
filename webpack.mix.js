let mix = require('laravel-mix');

mix.scripts([
	'resources/assets/js/core/jquery.min.js',
	'resources/assets/js/core/popper.min.js',
	'resources/assets/js/core/bootstrap.min.js',
	'resources/assets/js/core/jquery.slimscroll.min.js',
	'resources/assets/js/core/jquery.scrollLock.min.js',
	'resources/assets/js/core/jquery.appear.min.js',
	'resources/assets/js/core/jquery.countTo.min.js',
	'resources/assets/js/core/js.cookie.min.js',
	'resources/assets/js/codebase.js',
	'resources/assets/js/plugins/bootstrap-notify/bootstrap-notify.js',
	'resources/assets/js/plugins/select2/select2.full.js',
	'resources/assets/js/plugins/sweetalert2/es6-promise.auto.min.js',
	'resources/assets/js/plugins/sweetalert2/sweetalert2.min.js',
	'resources/assets/js/script.js'
], 'public/js/script.js')
.minify('public/js/script.js');


mix.styles([
	'resources/assets/js/plugins/select2/select2.min.css',
    'resources/assets/js/plugins/select2/select2-bootstrap.css',
    'resources/assets/js/plugins/sweetalert2/sweetalert2.min.css',
    'resources/assets/css/codebase.css',
    'resources/assets/css/themes/pulse.min.css',
    'resources/assets/css/style.css',
], 'public/css/style.css')
.minify('public/css/style.css');

// mix.copyDirectory('resources/assets/css/themes', 'public/css/themes');
mix.copyDirectory('resources/assets/fonts', 'public/fonts');
mix.copyDirectory('resources/assets/img', 'public/img');
mix.copyDirectory('resources/assets/js/plugins', 'public/plugins');