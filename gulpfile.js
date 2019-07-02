/*=== Gulp Plugins ===*/
var gulp         = require('gulp');
var sass         = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var cssnano      = require('gulp-cssnano');
var watch        = require('gulp-watch');
var rename       = require('gulp-rename');
var gCrashSound = require('gulp-crash-sound');

gCrashSound.config({
    file: './grunt/pop.mp3'
});


/*=== Sass -> Prefix -> Minify ===*/
gulp.task('styles', function () {
    gulp.src('./styles/scss/**/*.scss')
        .pipe(sass().on('error', function(e){
            gCrashSound.play();
            sass.logError(e);
            return true;    
        }))
        .pipe(sass().on('error', sass.logError))
        .pipe(cssnano())
        .pipe(gulp.dest('./'))
});

/*=== Watch Styles ===*/
gulp.task('watch', function() {
    gulp.watch('./styles/scss/**/*.scss', ['styles']);
});

/*=== Default Gulp task run watch ===*/
gulp.task('default', ['watch']);