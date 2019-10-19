/*
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

const {series, src, dest, watch, parallel} = require('gulp');
const concat = require('gulp-concat');
const minifyCSS = require('gulp-csso');
const gulpSass = require('gulp-sass');
const del = require('del');


// Combine All js files into one
const scripts = () => src([
  'node_modules/jquery/dist/jquery.min.js',
  'node_modules/bootstrap/dist/js/bootstrap.min.js',
  './resources/js/mediaelement-and-player.min.js',
  './resources/js/app.js'
], {sourcemaps: true})
  .pipe(concat('app.js'))
  .pipe(dest('./public/assets/js/', {sourcemaps: "."}));

// Move CSS and SCSS to ./dist/css
const scss = () => src('./resources/sass/app.scss', {sourcemaps: true})
  .pipe(gulpSass())
  .pipe(minifyCSS())
  .pipe(dest('./public/assets/css/', {sourcemaps: "."}));

// clean the dist directory
const clean = () => del(['./public/assets/js', './public/assets/css']);

// watch for changes
const watcher = () => watch('./resources/scss/*.scss', scss());

module.exports = {
    scss,
    watch: watcher,
    default: series(clean, parallel(scripts, scss))
};
