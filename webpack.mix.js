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
.sass('resources/assets/sass/course-index.scss', 'public/css').version()
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
.sass('resources/assets/sass/teacher.scss', 'public/css')
.sass('resources/assets/sass/creview.scss', 'public/css')
.sass('resources/assets/sass/mycourse.scss', 'public/css')
.sass('resources/assets/sass/app.scss', 'public/css')


.sass('resources/assets/sass/signup.scss', 'public/css')
.sass('resources/assets/sass/forget.scss', 'public/css')
.sass('resources/assets/sass/admin_c_index.scss', 'public/css')
.sass('resources/assets/sass/admin_course_new.scss', 'public/css')
.sass('resources/assets/sass/admin_course_offline.scss', 'public/css')
.sass('resources/assets/sass/admin_course_show.scss', 'public/css')
.sass('resources/assets/sass/offline_show.scss', 'public/css')
.sass('resources/assets/sass/admin_lesson_index.scss', 'public/css')
.sass('resources/assets/sass/admin_lesson_audio.scss', 'public/css')
.sass('resources/assets/sass/admin-lesson-new.scss', 'public/css')
.sass('resources/assets/sass/admin_lesson_show.scss', 'public/css')
.sass('resources/assets/sass/admin_lesson_audio_show.scss', 'public/css')
.sass('resources/assets/sass/user-index.scss', 'public/css')
.sass('resources/assets/sass/user-profile.scss', 'public/css')
.sass('resources/assets/sass/admin_teacher_index.scss', 'public/css')
.sass('resources/assets/sass/admin_teacher_new.scss', 'public/css')
.sass('resources/assets/sass/admin_teacher_show.scss', 'public/css')
.sass('resources/assets/sass/admin_client_index.scss', 'public/css')
.sass('resources/assets/sass/admin_client_show.scss', 'public/css')
.sass('resources/assets/sass/admin_imgset_index.scss', 'public/css')

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
.js('resources/assets/js/teacher.coffee', 'public/js')
.js('resources/assets/js/creview.coffee', 'public/js')
.js('resources/assets/js/mycourse.coffee', 'public/js')

.js('resources/assets/js/signin.coffee', 'public/js')
.js('resources/assets/js/signup.coffee', 'public/js')
.js('resources/assets/js/forget.coffee', 'public/js')
.js('resources/assets/js/admin_c_index.coffee', 'public/js')
.js('resources/assets/js/admin_course_show.coffee', 'public/js')
.js('resources/assets/js/admin_lesson_index.coffee', 'public/js')
.js('resources/assets/js/admin_lesson_show.coffee', 'public/js')
.js('resources/assets/js/admin-lesson-new.coffee', 'public/js')
.js('resources/assets/js/admin_teacher_index.coffee', 'public/js')
.js('resources/assets/js/admin_client_index.coffee', 'public/js')
.js('resources/assets/js/admin_client_show.coffee', 'public/js')
.js('resources/assets/js/admin-layout.coffee', 'public/js');
 mix.version();

// mix.js('resources/assets/js/app.js', 'public/js')
//     .sass('resources/assets/sass/app.scss', 'public/css');

