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

mix.setPublicPath(__dirname);

mix.options({ processCssUrls: false, imgLoaderOptions: { enabled: false } })
	.sass('resources/assets/sass/app.scss', 'publishable/assets/css', { implementation: require('node-sass') })
	.js('resources/assets/js/app.js', 'publishable/assets/js')
	.copy('node_modules/element-ui/lib/theme-chalk/fonts', 'publishable/assets/fonts')
	.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'publishable/assets/vendor/@fortawesome/fontawesome-free/webfonts')
	.copy('node_modules/@fortawesome/fontawesome-free/css', 'publishable/assets/vendor/@fortawesome/fontawesome-free/css')