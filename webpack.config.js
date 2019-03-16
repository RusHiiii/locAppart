var Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')

    /*
     * ENTRY CONFIG
    */
    .addEntry('app', './assets/js/entryPoint/app.js')
    .addEntry('accueil', './assets/js/entryPoint/accueil.js')
    .addEntry('login', './assets/js/entryPoint/login.js')
    .addEntry('parametre', './assets/js/entryPoint/parametre.js')
    .addEntry('email', './assets/js/entryPoint/email.js')
    .addEntry('ajout', './assets/js/entryPoint/ajout.js')
    .addEntry('gestion', './assets/js/entryPoint/gestion.js')
    .addEntry('mail', './assets/js/entryPoint/mail.js')
    .addEntry('information', './assets/js/entryPoint/information.js')
    .addEntry('listing', './assets/js/entryPoint/listing.js')
    .addEntry('fiche', './assets/js/entryPoint/fiche.js')

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())

    .enableVersioning(Encore.isProduction())
;

if(Encore.isProduction()){
    Encore
        .configureBabel(function(babelConfig) {
            // add additional presets
            babelConfig.presets.push('env');
            babelConfig.presets.push('minify');
        })

        .enablePostCssLoader((options) => {
            options.config = {
                path: 'postcss.config.js'
            };
        })
    ;
}

module.exports = Encore.getWebpackConfig();
