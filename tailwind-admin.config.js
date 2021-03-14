const colors = require( 'tailwindcss/colors' )
const defaultTheme = require( 'tailwindcss/defaultTheme' );

module.exports = {
	purge: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./resources/views/components/**/*.blade.php',
		'./resources/views/admin/**/*.blade.php'
	],

    darkMode: 'class',

	theme: {
		colors: {
			transparent: 'transparent',
			current: 'currentColor',

			black: colors.black,
			white: colors.white,
			gray: colors.gray,
			red: colors.red,
			orange: colors.orange,
			// yellow: colors.amber,
			green: colors.emerald,
			// blue: colors.blue,
			primary: colors.indigo,
			// purple: colors.violet,
			// pink: colors.pink,
		},

		extend: {
			fontFamily: {
				sans: [ 'Nunito', ...defaultTheme.fontFamily.sans ],
			},
		},
	},

	variants: {
		extend: {
			opacity: [ 'disabled' ],
		},
	},

	plugins: [
		require( 'tailwind-css-variables' )(),
		require( './resources/js/admin/forms' ),
	],
};
