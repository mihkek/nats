let mix = require('laravel-mix')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your application.
 |
 */

/*
 * npm i jquery --save or yarn add jquery
 * commentout below code to enable juery autoloading
 * this allows you to use $() in all files.
 */

// mix.autoload({
//     jquery: ['$', 'window.jQuery', 'jQuery']
// });

//====set alias for isotope

const path = require('path')
const WebpackShellPlugin = require('webpack-shell-plugin');

mix.webpackConfig({
    resolve: {
        alias: {
            'masonry': 'masonry-layout',
            'isotope': 'isotope-layout',
            // custom aliases for easy reference
            'src': path.resolve(__dirname, 'resources/assets/'),
            'assets': path.resolve(__dirname, 'resources/assets/assets/'),
            'components': path.resolve(__dirname, 'resources/assets/components/'),
            'pages': path.resolve(__dirname, 'resources/assets/components/pages/'),
        }
    },
    // https://github.com/JeffreyWay/laravel-mix/issues/936#issuecomment-331418769
    output: {
        publicPath: "/",
        chunkFilename: mix.inProduction() ? 'js/[name].[chunkhash].js' : 'js/[name].js'
    },
    module: {
    rules: [
      {
        test: /\.hbs$/,
        loader: "handlebars-template-loader"
      },
      {
        test: require.resolve('zepto'),
        use: 'imports-loader?this=>window'
      }
    ]
  },
});

// Setup Autoprefixer
mix.options({
    postCss: [
        require('autoprefixer')(),
        /**
         * Automatically create rtl css
         * applies styles based on the 'dir' attribute on <html></html>
         * eg: <html dir="ltr"></html>
         * experimental, broken
         */
        // require('postcss-rtl')()
    ]
})

// ===public path
mix.setPublicPath('./')


// ===compile our main.js file
mix.js('resources/assets/main.js', 'public/')
    
    // Add any additional vendor modules that need to be cached
    // remove any unused libraries in the array as they will be included in the vendor bundle

// set path for production link
mix.setResourceRoot('/')


// Disable all OS notifications
// mix.disableNotifications()


// Disable all Success notifications
// mix.disableSuccessNotifications()


mix.webpackConfig({
  
});




// копирование базовых картинок и шрифтов
/*mix.copyDirectory('resources/assets/img', 'public/img');
mix.copyDirectory('resources/assets/fonts', 'public/fonts');*/



// финальная сборка-микс
mix





	//################## ФАЙЛЫ БУТСТРАП ##############################################
	.sass('resources/assets/sass/admin_bootstrap.scss', 		'public/css') 
	.combine([
		'resources/assets/js/bootstrap-3.3.7.min.js',
		'resources/assets/js/bootstrap-tooltip.js',
		'resources/assets/js/bootstrap-datetimepicker.min.js',
		'resources/assets/js/bootstrap-datetimepicker.ru.js',
	], 'public/js/admin_bootstrap.js')







	// админки сборный js и css 
	.js('resources/assets/js/admin_app.js', 'public/js')
	.sass('resources/assets/sass/admin_app.scss', 'public/css') 

// админки шрифты 
	.sass('resources/assets/sass/admin_fonts.scss', 'public/css') 






	//################## ФАЙЛЫ jquery ##############################################
	.sass('resources/assets/sass/admin_jquery.scss', 'public/css') 
	.combine([
		'resources/assets/js/jquery-3.3.1.min.js',
//		'resources/assets/js/jquery-migrate-1.4.1.js', // включать только для отладки
//		'resources/assets/js/jquery-migrate-3.0.0.js', // включать только для отладки
		'resources/assets/js/jquery-ui-1.12.1.min.js',
		'resources/assets/js/jquery-form-3.51.0.js',
	], 'public/js/admin_jquery.js')






	// админки css только для страницы логина
	.sass('resources/assets/sass/admin_login.scss', 'public/css').version(); 

