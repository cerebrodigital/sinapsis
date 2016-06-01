var gulp = require('gulp');
var gulpif = require('gulp-if');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var Elixir = require('laravel-elixir');
var gulpFilter = require('gulp-filter');
var config = Elixir.config;

Elixir.extend('uglify', function (src, outputPath, baseDir, options) {
    if (typeof outputPath == 'object') {
        options = outputPath;
        outputPath = null;
    }

    if (typeof baseDir == 'object') {
        options = baseDir;
        baseDir = null;
    }

    var paths = new Elixir.GulpPaths()
        .src(src, baseDir || config.get('assets.js.folder'))
        .output(outputPath || config.get('public.js.outputFolder'));

    options = typeof options == 'undefined' ? {} : options;

    var extConditon = function(){
        if (options.suffix === undefined){
            return true;
        }

        return options.suffix ? true : false;
    }

    new Elixir.Task('uglify', function () {
        var filter  = gulpFilter(['**/*', '!**/*.min.js']);
        var uglifyOptions = options;

        return gulp.src(paths.src.path)
            .pipe(filter)
            .pipe(uglify(uglifyOptions))
            .pipe(rename(paths.output.name))
            .pipe(gulpif(extConditon, rename({extname: '.min.js'})))
            .pipe(gulp.dest(paths.output.baseDir))
            .pipe(new Elixir.Notification().message('Uglified!'));
    })
    .watch(paths.src.path);
});
