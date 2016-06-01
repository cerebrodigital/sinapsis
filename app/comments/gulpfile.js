process.env.DISABLE_NOTIFIER = true;

var elixir = require('laravel-elixir');
require('./elixir-uglify');
require('laravel-elixir-rollup');

elixir.config.sourcemaps = false;

var jsDest  = 'public/js/';
var cssDest = 'public/css/';

//var jsDest  = '../laravel/public/vendor/comments/js/';
//var cssDest = '../laravel/public/vendor/comments/css/';

elixir(function (mix) {
    // Compile sass.
    mix.sass('bootstrapless.scss', cssDest + 'bootstrapless.css', {compress: true})
       .sass('comments.scss', cssDest + 'comments.css')
       .sass('admin.scss', cssDest + 'admin.css')
       .sass('demo.scss', cssDest + 'demo.css');

    // admin.js
    mix.rollup('admin/index.js', jsDest + 'admin.js', {
        format: 'umd',
        globals: {jquery: 'jQuery', vue: 'Vue', prism: 'Prism', autosize: 'autosize'},
    });

    // comments.js
    mix.rollup('index.js', jsDest + 'comments.js', {
        format: 'umd',
        globals: {jquery: 'jQuery', vue: 'Vue'},
    });

    // utils.js
    mix.scripts(['autosize.js', 'jquery.timeago.js', 'prism.js'], jsDest + 'utils.js', 'public/js');

    // Minify.
    // mix.uglify('admin.js', jsDest + 'admin.js', jsDest);
    mix.uglify('comments.js', jsDest + 'comments.js', jsDest);
    mix.uglify('utils.js', jsDest + 'utils.js', jsDest, {suffix: false});
});
