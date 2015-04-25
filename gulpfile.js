var gulp 		= require('gulp');
var gutil 		= require('gulp-util');
var notify 		= require('gulp-notify');
var sass 		= require('gulp-ruby-sass');
var autoprefix 	= require('gulp-autoprefixer');
var minifyCSS 	= require('gulp-minify-css');
var rename		= require('gulp-rename');
var include		= require('gulp-include');
var uglify		= require('gulp-uglify');
var shell		= require('gulp-shell');

var assetsDir	= 'resources/assets';
var outputDir	= 'public/assets';

gulp.task('main-css', function(){
	return gulp.src(assetsDir + '/sass/main.sass')
		.pipe(sass())
		.on('error', handleSassError)
		.pipe(autoprefix('last 3 version'))
		.pipe(minifyCSS({keepSpecialComments:0}))
        .pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest(outputDir + '/css'))
	    .pipe(notify('main CSS compiled'));
});

gulp.task('center-css', function(){
	return gulp.src(assetsDir + '/sass/center.sass')
		.pipe(sass())
		.on('error', handleSassError)
		.pipe(autoprefix('last 3 version'))
		.pipe(minifyCSS({keepSpecialComments:0}))
        .pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest(outputDir + '/css'))
	    .pipe(notify('center CSS compiled'));
});

gulp.task('center-js', function(){
	return gulp.src(assetsDir + '/center.js')
		.pipe(include())
		.pipe(uglify())
		.on('error', handleJsError)		
        .pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest(outputDir + '/js'))
	    .pipe(notify('center JS compiled'));
});

gulp.task('main-js', function(){
	return gulp.src(assetsDir + '/js/main.js')
		.pipe(include())
		.pipe(uglify())
		.on('error', handleJsError)		
        .pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest(outputDir + '/js'))
	    .pipe(notify('main JS compiled'));
});

gulp.task('lib-js', function(){
	return gulp.src(assetsDir + '/lib.js')
		.pipe(include())
		.pipe(uglify())
		.on('error', handleJsError)		
        .pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest(outputDir + '/js'))
	    .pipe(notify('lib JS compiled'));
});

gulp.task('watch', function(){
	gulp.watch(assetsDir + '/**/*.sass', ['main-css', 'center-css']);
	gulp.watch(assetsDir + '/center.js', ['center-js']);
	gulp.watch(assetsDir + '/lib.js', ['lib-js']);
	gulp.watch(assetsDir + '/**/*.js', ['main-js']);
});

gulp.task('default', ['main-css', 'center-css', 'main-js', 'center-js', 'lib-js', 'watch']);

function handleJsError(err, line) {
	gulp.src(assetsDir + '/main.js').pipe(notify(err + ' ' + line));
	this.emit('end');
}

function handleSassError(err) {
	gulp.src(assetsDir + '/main.sass').pipe(notify(err));
	this.emit('end');
}