var gulp = require('gulp'),
    fileInclude = require('gulp-file-include'),
    sass = require('gulp-sass'),
    extender = require('gulp-html-extend');

var concat = require('gulp-concat');//合并文件
var uglify = require('gulp-uglify');//压缩代码
var rename = require('gulp-rename');//重命名
var minifycss = require('gulp-minify-css'); //压缩css

var anyHtmlGlob = 'resources/views/src/**/[^_]*.html';
var anyPhpGlob = 'resources/views/src/**/[^_]*.php';
var anyScssGlob = 'resources/assets/sass/**/*.scss';
var anyImageGlob = 'resources/assets/images/**/*.*';
var anyAudioGlob = 'resources/assets/audio/**/*.*';
var anyLibGlob = 'resources/assets/libs/**/*.*';
var anyJsGlob = 'resources/assets/js/**/*.*';

gulp.task('html', function () {
    gulp.src([anyHtmlGlob])
        .pipe(extender({
            annotations: true,
            verbose: true
        }))
        .pipe(fileInclude({
            prefix: '@@',
            base: '@file'
        }))
        .pipe(gulp.dest('public'));
    //.pipe(gulp.dest('resources/views/'));
    console.log("Html building finished");
});

gulp.task('php', function () {
    gulp.src([anyPhpGlob])
        .pipe(extender({
            annotations: true,
            verbose: true
        }))
        .pipe(fileInclude({
            prefix: '@@',
            base: '@file'
        }))
        .pipe(gulp.dest('resources/views/'));
    console.log("Php building finished");
});

gulp.task('scss', function () {
    gulp.src(anyScssGlob)
        .pipe(sass())
        .pipe(gulp.dest('public/css'));
});

gulp.task('image', function () {
    gulp.src(anyImageGlob)
        .pipe(gulp.dest('public/images'));
});

gulp.task('audio', function () {
    gulp.src(anyAudioGlob)
        .pipe(gulp.dest('public/audio'));
});

gulp.task('libs', function () {
    gulp.src(anyLibGlob)
        .pipe(gulp.dest('public/libs'));
});
gulp.task('js', function () {
    gulp.src(anyJsGlob)
        .pipe(gulp.dest('public/js'))
});

gulp.watch(['resources/views/src/**/*.html'], ['html']);
gulp.watch(['resources/views/src/**/*.php'], ['php']);
gulp.watch(anyScssGlob, ['scss']);
gulp.watch(anyImageGlob, ['image']);
gulp.watch(anyAudioGlob, ['audio']);
gulp.watch(anyLibGlob, ['libs']);
gulp.watch(anyJsGlob, ['js']);
gulp.task('default', ['html', 'scss', 'image', 'audio', 'libs', 'js', 'php']);
