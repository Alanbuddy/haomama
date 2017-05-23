const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/app.coffee', 'public/js')
.webpackConfig({
        module: {
            rules: [
                { test: /\.coffee$/, loader: 'coffee-loader' }
            ]
        }
   })
.sass('resources/assets/sass/layout.scss', 'public/css')
.sass('resources/assets/sass/register.scss', 'public/css')
.sass('resources/assets/sass/course-index.scss', 'public/css')
.sass('resources/assets/sass/setting-index.scss', 'public/css')
.sass('resources/assets/sass/setting-create.scss', 'public/css')
.sass('resources/assets/sass/mine-index.scss', 'public/css')
.sass('resources/assets/sass/mine-show.scss', 'public/css')
.sass('resources/assets/sass/course-create.scss', 'public/css')
.sass('resources/assets/sass/sign.scss', 'public/css')
.sass('resources/assets/sass/pay-success.scss', 'public/css')
.sass('resources/assets/sass/search-result.scss', 'public/css')
.sass('resources/assets/sass/message.scss', 'public/css')
.sass('resources/assets/sass/course-show.scss', 'public/css')


.js('resources/assets/js/layout.coffee', 'public/js')
.js('resources/assets/js/register.coffee', 'public/js')
.js('resources/assets/js/course-index.coffee', 'public/js')
.js('resources/assets/js/setting-index.coffee', 'public/js')
.js('resources/assets/js/setting-create.coffee', 'public/js')
.js('resources/assets/js/mine-index.coffee', 'public/js')
.js('resources/assets/js/mine-show.coffee', 'public/js')
.js('resources/assets/js/course-create.coffee', 'public/js')
.js('resources/assets/js/search-result.coffee', 'public/js')
.js('resources/assets/js/sign.coffee', 'public/js')
.js('resources/assets/js/pay-success.coffee', 'public/js')
.js('resources/assets/js/message.coffee', 'public/js')
.js('resources/assets/js/course-show.coffee', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
