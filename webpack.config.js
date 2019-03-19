// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore
    // directory where all compiled assets will be stored
    .setOutputPath('web/build/')

    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath('/build')

    .addEntry('bootstrap', './src/AppBundle/Resources/public/js/bootstrap.min.js')
    .addEntry('fullcalendar', './src/AppBundle/Resources/public/js/fullcalendar.default-settings.js')
    .addEntry('fullcalendarlimit', './src/AppBundle/Resources/public/js/fullcalendarlimit.js')
    .addEntry('jquery', './src/AppBundle/Resources/public/js/jquery-3.2.1.js')
    .addEntry('jquery-ui', './src/AppBundle/Resources/public/js/jquery-ui.min.js')
    .addEntry('jquery.easing', './src/AppBundle/Resources/public/js/jquery.easing.1.3.js')
    .addEntry('jquery.magnific-popup', './src/AppBundle/Resources/public/js/jquery.magnific-popup.min.js')
    .addEntry('jquery.qtip', './src/AppBundle/Resources/public/js/jquery.qtip.js')
    .addEntry('jquery.waypoints', './src/AppBundle/Resources/public/js/jquery.waypoints.min.js')
    //.addEntry('jquery-slider', './src/AppBundle/Resources/public/js/jssor.slider-26.5.0.min.js')
    .addEntry('mainjs', './src/AppBundle/Resources/public/js/main.js')
    .addEntry('modernizr', './src/AppBundle/Resources/public/js/modernizr-2.6.2.min.js')
    //.addEntry('respond', './src/AppBundle/Resources/public/js/respond.min.js')
    .addEntry('salvattorejs', './src/AppBundle/Resources/public/js/salvattore.min.js')


    .addStyleEntry('animate', './src/AppBundle/Resources/public/css/animate.css')
    .addStyleEntry('base', './src/AppBundle/Resources/public/css/base.css')
    .addStyleEntry('fonts', './src/AppBundle/Resources/public/css/fonts.css')
    .addStyleEntry('icomoon', './src/AppBundle/Resources/public/css/icomoon.css')
    .addStyleEntry('qtip.css', './src/AppBundle/Resources/public/css/jquery.qtip.css')
    .addStyleEntry('magnific-popup', './src/AppBundle/Resources/public/css/magnific-popup.css')
    .addStyleEntry('main.css', './src/AppBundle/Resources/public/css/main.css')
    .addStyleEntry('salvattore.css', './src/AppBundle/Resources/public/css/salvattore.css')
    .addStyleEntry('style', './src/AppBundle/Resources/public/css/style.css')
    .addStyleEntry('vendore', './src/AppBundle/Resources/public/css/vendor.css')

    //C:\wamp64\www\proiectWEB\web\assets\js\main.js

    // allow sass/scss files to be processed
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

    // create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning()

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    .enableSassLoader(function(sassOptions) {}, {
         resolveUrlLoader: false
     })
;

// export the final configuration
module.exports = Encore.getWebpackConfig();
