let mix = require('laravel-mix');

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


mix.webpackConfig({
	resolve: {
		modules: [
			path.resolve('./node_modules')
		]
	}
});

mix.setPublicPath(path.resolve(__dirname));

// frontend
mix
	.sass('resources/scss/social.scss', 'assets/css/social.css')
	.sass('resources/scss/admin.scss', 'assets/css/admin.css')
	.js('resources/js/admin.js', 'assets/js/admin.js');
