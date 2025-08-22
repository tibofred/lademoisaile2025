// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore
// the project directory where all compiled assets will be stored
    .setOutputPath('web/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    // will create web/build/app.js and web/build/app.css
    .addEntry('app', './assets/js/app.js')

    // this creates a 'vendor.js' file with jquery and the bootstrap JS module
    // these modules will *not* be included in page1.js or page2.js anymore
    .createSharedEntry('vendor', [
        'jquery',
        'bootstrap',

        // you can also extract CSS - this will create a 'vendor.css' file
        // this CSS will *not* be included in page1.css or page2.css anymore
        // 'bootstrap-sass/assets/stylesheets/_bootstrap.scss'
    ])


    // allow sass/scss files to be processed
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

// create hashed filenames (e.g. app.abc123.css)
// .enableVersioning()
;

Encore.enableSassLoader(function(sassOptions) {}, {
    resolveUrlLoader: false
});
Encore.autoProvidejQuery();

// export the final configuration
module.exports = Encore.getWebpackConfig();
