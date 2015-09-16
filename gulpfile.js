var gulp = require('gulp');
var sass = require('gulp-sass');
var rename = require('gulp-rename');
var minifycss = require('gulp-minify-css');
var autoprefixer = require('gulp-autoprefixer');
var debug = require('gulp-debug');
var changed = require('gulp-changed');
var imagemin = require('gulp-imagemin');
var minifyHTML = require('gulp-minify-html');

gulp.task('sass', function() {
    gulp.src('src/src/base.scss')
        .pipe(debug({title: 'gulp-debug [sass]:'}))
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
        .pipe(autoprefixer({browsers: ['last 3 version']}))
        .pipe(rename('style.css'))
        .pipe(gulp.dest('dist/css'))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifycss())
        .pipe(gulp.dest('dist/css'));
});

gulp.task('html', function() {
    gulp.src(['src/**/*.html', '!**/*~']) // don't copy backup files
        .pipe(changed('dist/'))
        .pipe(debug({title: 'gulp-debug [html]:'}))
        .pipe(minifyHTML({conditionals: true}))
        .pipe(gulp.dest('dist/'));
});

// blog task separate, in case changes are to be made later
gulp.task('blog', function() {
    gulp.src('src/blog/**/*.php')
        .pipe(changed('dist/blog/'))
        .pipe(debug({title: 'gulp-debug [blog]:'}))
        .pipe(gulp.dest('dist/blog/'));
});

gulp.task('images', function() {
    gulp.src('src/img/**/*')
        .pipe(changed('dist/img/'))
        .pipe(debug({title: 'gulp-debug [images]:'}))
        .pipe(imagemin())
        .pipe(gulp.dest('dist/img/'));
});

// copy everything else that we may expect in the final build
gulp.task('misc', function() {
    gulp.src('src/favicon.ico')
        .pipe(changed('dist/'))
        .pipe(debug({title: 'gulp-debug [misc-favicon]:'}))
        .pipe(gulp.dest('dist/'));
    
    //copy portfolio
    gulp.src(['src/portfolio/**/*', '!**/*.html']) // don't get the html
        .pipe(changed('dist/portfolio/'))
        .pipe(debug({title: 'gulp-debug [misc-portfolio]:'}))
        .pipe(gulp.dest('dist/portfolio/'));
});

gulp.task('build', ['sass', 'html', 'blog', 'images', 'misc']);