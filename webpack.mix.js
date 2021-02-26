const mix = require( 'laravel-mix' )
const path = require( 'path' )

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

mix
	.disableNotifications()
	.webpackConfig( {
		resolve: {
			alias: {
				'@': path.resolve( 'resources/js' ),
				'+': path.resolve( 'resources/js/utils' ),
			},
		},
	} )

if ( process.env.npm_config_admin ) {
	mix.setPublicPath( 'public/admin' )

	mix
		.js( 'resources/js/admin/app.js', 'public/admin' )
		.postCss( 'resources/css/app.css', 'public/admin', [
			require( 'postcss-import' ),
			require( 'tailwindcss' )('tailwind-admin.config.js'),
			require( 'autoprefixer' ),
		] )
} else {
	mix
		.js( 'resources/js/app.js', 'public/js' )
		.postCss( 'resources/css/app.css', 'public/css', [
			require( 'postcss-import' ),
			require( 'tailwindcss' ),
			require( 'autoprefixer' ),
		] )
}
