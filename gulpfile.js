'use strict';

var gulp         = require('gulp');
var postcss      = require('gulp-postcss');
var sourcemaps   = require('gulp-sourcemaps');
var autoprefixer = require('autoprefixer');
var sass         = require('gulp-sass');

gulp.task('compile', function () {

    sass.compiler = require('node-sass');

    return gulp.src('./assets/scss/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(sourcemaps.init())
        .pipe(postcss([ autoprefixer() ]))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./'));
});

gulp.task('watch', function () {
    gulp.watch('./assets/scss/**/*.scss', ['compile']);
});
