// CONFIG
var gulp = require('gulp');
var cssnano = require('gulp-cssnano');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var deporder = require('gulp-deporder');
var stripdebug = require('gulp-strip-debug');

/* TASKS */

/* SCSS/SASS Interpreter */

/* Run this only when you need to recompile Bootstrap CSS */
gulp.task('app-css', function(){
   return gulp.src('resources/sass/app.scss')
       .pipe(sass())
         .on('error', function (err) {
           console.log(err.toString());
           this.emit('end');
       })
      .pipe(cssnano())
      .pipe(gulp.dest('public/css/'));
});


gulp.task('admin-css', function(){
   return gulp.src('resources/admin-scss/style.scss')
      .pipe(sass())
        .on('error', function (err) {
          console.log(err.toString());
          this.emit('end');
          })
      .pipe(cssnano())
      .pipe(gulp.dest('public/css/admin'));
});


/* JS Concatenator */
gulp.task('js', function(){
//public/js/app.js
    return gulp.src(['resources/js/admin/_partials/*.js'])
        .pipe(concat('admin.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/js'));
});

/* WATCH */
gulp.task('watch', function(){
    gulp.watch('resources/admin-scss/**/*.scss', gulp.series('admin-css') );
    gulp.watch('resources/admin-scss/_partials/*.scss', gulp.series('admin-css') );
    gulp.watch('resources/js/partials/*.js', gulp.series('js') );
});
