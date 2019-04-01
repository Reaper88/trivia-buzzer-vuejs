var Encore = require('@symfony/webpack-encore');
var webpack = require('webpack');

Encore
    .setOutputPath('public/assets/build')
    .setPublicPath('/assets/build')
    .cleanupOutputBeforeBuild()
    .addEntry('app', './src/assets/js/app.js')
    //.addStyleEntry('stylesheet', './src/assets/scss/stylesheet.scss')
//    .addPlugin(new webpack.ProvidePlugin({
//            $: 'jquery',
//            jQuery: 'jquery',
//            'window.jQuery': 'jquery',
//            Popper: ['popper.js', 'default']
//          }))
    // allow sass/scss files to be processed
    .enableSassLoader(function(sassOptions) {}, {
         resolveUrlLoader: false
     })
    .enableVueLoader()
    .enableSingleRuntimeChunk()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;

// export the final configuration
 var config = Encore.getWebpackConfig();
 config.resolve.alias = {
     'vue$': 'vue/dist/vue.esm.js'
 }
module.exports = config