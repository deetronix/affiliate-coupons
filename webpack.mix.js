let mix = require('laravel-mix');

mix
    // Override the underlying webpack configuration directly.
    .webpackConfig({
        externals: {
            jquery: 'jQuery',
        }
    })
    // Configure options.
    .options({
        processCssUrls: false, // Don't perform any css url rewriting by default
    })

    // Set public destination path.
    .setPublicPath('assets/dist')

    // Compile JavaScript files.
    .js('assets/src/admin/index.js', 'js/admin.js')
    .js('assets/src/public/index.js', 'js/main.js')

    // Compile CSS Files.
    .less('assets/src/admin/index.less', 'css/admin.css')
    .less('assets/src/public/index.less', 'css/main.css')
    .less('assets/src/public/index-amp.less', 'css/amp.css')
;
