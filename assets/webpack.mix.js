const mix = require('laravel-mix');
//const exec = require('child_process').exec;
//require('dotenv').config();

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

 //const glob = require('glob')
 //const path = require('path')

/*
 |----------------------------------------------s----------------------------
 | Vendor assets
 |--------------------------------------------------------------------------
 */

 mix.js('src/app.js', 'js/');


 //mix.version();