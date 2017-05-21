'use strict';

var
    gulp = require('gulp'),
    sass = require('gulp-sass'),
    rename = require('gulp-rename'),
    cleanCSS = require('gulp-clean-css'),
    uglify = require('gulp-uglify'),
    jshint = require('gulp-jshint'),
    concat = require('gulp-concat'),
    del = require('del');

var
    cssSource = 'web/css/',
    jsSource = 'web/js/',
    dest = 'web/dist/';

var bootstrapSass = {
    in: './node_modules/bootstrap-sass/'
};

var fonts = {
    in: [cssSource + 'fonts/*.*', bootstrapSass.in + 'assets/fonts/**/*'],
    out: dest + 'fonts/'
};

var scss = {
    in: cssSource + 'sass/main.scss',
    out: dest + 'css/',
    watch: cssSource + 'sass/**/*',
    sassOpts: {
        outputStyle: 'nested',
        precision: 3,
        errLogToConsole: true,
        includePaths: [bootstrapSass.in + 'assets/stylesheets']
    }
};

var js = {
    in: jsSource,
    out: dest + 'js/',
    watch: jsSource + '**/*.js'
};

// copy bootstrapSass required fonts to dest
gulp.task('fonts', ['clean'], function () {
    return gulp
        .src(fonts.in)
        .pipe(gulp.dest(fonts.out));
});

gulp.task('sass', ['fonts'], function () {
    return gulp.src(scss.in)
        .pipe(sass(scss.sassOpts))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(scss.out));
});

gulp.task('scripts', ['clean'], function() {
    return gulp.src(js.watch)
        .pipe(concat('main.js'))
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(gulp.dest(js.out));
});

gulp.task('clean', function() {
    return del([scss.out, fonts.out, js.out]);
});

gulp.task('default', ['sass', 'scripts'], function () {
    gulp.watch(scss.watch, ['sass']);
    gulp.watch(js.watch, ['scripts']);
});
