const mix = require("laravel-mix"),
    theme = "default";
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.browserSync({
    proxy: {
        target: "https://fronds.local", reqHeaders: {
            "Access-Control-Allow-Origin": "*"
        }
    },
    port: 3002,
    cors: true
});
mix.js("resources/js/app.js", "public/js")
    .js(`resources/js/theme/${theme}/index.js`, `public/js/theme/${theme}/fronds.js`)
    .sass("resources/sass/app.scss", "public/css")
    .sass("resources/sass/fronds/admin/admin.scss", "public/css/admin")
    .version()
    .sourceMaps();
