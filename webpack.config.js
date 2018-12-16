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
    .addEntry('generic', './assets/js/entryPoint/generic.js')
    .addEntry('accueil', './assets/js/entryPoint/accueil.js')
    .addEntry('login', './assets/js/entryPoint/login.js')
    .addEntry('parametre', './assets/js/entryPoint/parametre.js')
    .addEntry('email', './assets/js/entryPoint/email.js')
    .addEntry('ajout', './assets/js/entryPoint/ajout.js')

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]',
        pattern: /\.(png|jpg|jpeg|ico)$/
    })

    .copyFiles({
        from: './assets/font',
        to: 'font/[path][name].[ext]',
        pattern: /\.(eot|ttf|woff|svg)$/
    })
;

module.exports = Encore.getWebpackConfig();
