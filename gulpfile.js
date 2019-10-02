var gulp = require('gulp');
var sass = require('gulp-sass');
var rename = require('gulp-rename');
var minifycss = require('gulp-clean-css');
var autoprefixer = require('gulp-autoprefixer');
var debug = require('gulp-debug');
var changed = require('gulp-changed');
var imagemin = require('gulp-imagemin');
var htmlmin = require('gulp-htmlmin');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

gulp.task('sass', function() {
    return gulp.src('src/css/base.scss')
        .pipe(debug({title: 'gulp-debug [sass]:'}))
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(rename('style.css'))
        .pipe(gulp.dest('dist/css'))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifycss())
        .pipe(gulp.dest('dist/css'));
});

gulp.task('html', function() {
    return gulp.src('src/**/*.html')
        .pipe(changed('dist/'))
        .pipe(debug({title: 'gulp-debug [html]:'}))
        .pipe(htmlmin({
            collapseWhitespace: true,
        }))
        .pipe(gulp.dest('dist/'));
});

// blog task separate, in case changes are to be made later
gulp.task('blog', function() {
    return gulp.src('src/blog/**/*.php')
        .pipe(changed('dist/blog/'))
        .pipe(debug({title: 'gulp-debug [blog]:'}))
        .pipe(gulp.dest('dist/blog/'));
});

gulp.task('images', function() {
    return gulp.src('src/img/**/*')
        .pipe(changed('dist/img/'))
        .pipe(debug({title: 'gulp-debug [images]:'}))
        .pipe(imagemin())
        .pipe(gulp.dest('dist/img/'));
});

gulp.task('js', function(done) {
    gulp.src('src/js/*.js')
        .pipe(debug({title: 'gulp-debug [js]'}))
        .pipe(concat('all.js'))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js/'));

    gulp.src('src/js/vendor/**/*.js')
        .pipe(debug({title: 'gulp-debug [vendor js]'}))
        .pipe(concat('vendor.js'))
        // already uglified
        .pipe(gulp.dest('dist/js/'));

    done();
});

// copy everything else that we may expect in the final build
gulp.task('misc', function(done) {
    gulp.src('src/favicon.ico')
        .pipe(changed('dist/'))
        .pipe(debug({title: 'gulp-debug [misc-favicon]:'}))
        .pipe(gulp.dest('dist/'));

    //copy portfolio
    gulp.src(['src/portfolio/**/*', '!**/*.html']) // don't get the html
        .pipe(changed('dist/portfolio/'))
        .pipe(debug({title: 'gulp-debug [misc-portfolio]:'}))
        .pipe(gulp.dest('dist/portfolio/'));

    // copy GPG key
    gulp.src('src/.well-known/**/*', {
        dot: true,
        base: 'src',
    }).pipe(changed('dist/.well-known/'))
        .pipe(debug({title: 'gulp-debug [misc-openpgp]:'}))
        .pipe(gulp.dest('dist/'));
    gulp.src('src/key.asc')
        .pipe(changed('dist/'))
        .pipe(debug({title: 'gulp-debug [misc-openpgp]:'}))
        .pipe(gulp.dest('dist/'));

    done();
});

gulp.task('build', gulp.parallel('sass', 'html', 'blog', 'images', 'js', 'misc'));
