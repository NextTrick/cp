// Load plugins
var gulp = require('gulp'),
    jade = require('gulp-jade'),
    browserSync = require('browser-sync'),
    coffee = require('gulp-coffee'),
    stylus = require('gulp-stylus'),
    copy = require('gulp-imagemin');

// Static server
gulp.task('server', function () {
 browserSync({
    server: 'dist/'
    });
 });

// Converts Jade to HTML (jade is including markdown files)
gulp.task('jade', function() {  // ['markdown'] forces jade to wait
    return gulp.src('./jade/*.jade')
    .pipe(jade({
            pretty: true,  // uncompressed
            }))
    .pipe(gulp.dest('./dist/html'));
});

gulp.task('coffee', function(){
    return gulp.src('./coffee/*.coffee')
    .pipe(coffee({ bare: true }))
    .pipe(gulp.dest('./dist/js'));
});

gulp.task('stylus', function () {
    return gulp.src('./stylus/*.styl')
    .pipe(stylus())
    .pipe(gulp.dest('./dist/css'))
});

gulp.task('copy:img', function() {
    return gulp.src('./images/*.*')
    .pipe(copy())
    .pipe(gulp.dest('./dist/images'));
});
// Default task
//gulp.task('default', ['styles', 'scripts', 'images', 'markdown', 'jade', 'watch']);

// Watch
gulp.task('watch', function () {
    gulp.start('server');
    gulp.watch("jade/*.jade", ['jade', browserSync.reload]);
    gulp.watch("coffee/*.coffee", ['coffee', browserSync.reload]);
    gulp.watch("stylus/*.styl", ['stylus', browserSync.reload]);
});
