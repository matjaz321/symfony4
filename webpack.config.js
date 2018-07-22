var Encore = require('@symfony/webpack-encore');

Encore
// the project directory where compiled assets will be stored
.setOutputPath('public/build/')
// the public path used by the web server to access the previous directory
.setPublicPath('/build')
// the public path you will use in Symfony's asset() function - e.g. asset('build/some_file.js')
.setManifestKeyPrefix('build/')

.cleanupOutputBeforeBuild()
.enableSourceMaps(!Encore.isProduction())

// the following line enables hashed filenames (e.g. app.abc123.css)
.enableVersioning(Encore.isProduction())

// uncomment to define the assets of the project
.addEntry('js/app', [
  './node_modules/jquery/dist/jquery.slim.js',
  './node_modules/popper.js/dist/popper.js',
  './node_modules/bootstrap/dist/js/bootstrap.min.js',
  './node_modules/holderjs/holder.min.js',
  './assets/css/app.css'
])
.addStyleEntry('css/app', [
  './node_modules/bootstrap/dist/css/bootstrap.min.css'
])

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use Sass/SCSS files
//.enableSassLoader()

// uncomment for legacy applications that require $/jQuery as a global variable
//.autoProvidejQuery()
;
module.exports = Encore.getWebpackConfig();
