const {series, src, dest, watch, parallel} = require('gulp');
const concat = require('gulp-concat');
const minifyCSS = require('gulp-csso');
const minifyJS = require('gulp-jsmin');
const gulpSass = require('gulp-sass');
const del = require('del');

// Combine All js files into one
const scripts = () => src([
  'node_modules/jquery/dist/jquery.min.js',
  'node_modules/bootstrap/dist/js/bootstrap.min.js',
  'node_modules/owl.carousel/dist/owl.carousel.min.js',
  './resources/js/v4/app.js'
], {sourcemaps: true})
  .pipe(concat('app.js'))
  .pipe(dest('./public/assets/js/', {sourcemaps: "."}));

const js = () => src('./public/assets/js/app.js')
  .pipe(minifyJS())
  .pipe(dest('./public/assets/js/', {sourcemaps: "."}));

// Move CSS and SCSS to ./dist/css
const scss = () => src([
  './resources/sass/v4/app.scss'
], {sourcemaps: true})
  .pipe(gulpSass())
  .pipe(minifyCSS())
  .pipe(dest('./public/assets/css/', {sourcemaps: "."}));

const css = () => src([
  'node_modules/bootstrap/dist/css/bootstrap.min.css',
  'node_modules/owl.carousel/dist/assets/owl.carousel.min.css',
  './public/assets/css/app.css',
])
  .pipe(concat('app.css'))
  .pipe(minifyCSS())
  .pipe(dest('./public/assets/css/', {sourcemaps: "."}));


// clean the dist directory
const clean = () => del(['./public/assets/js', './public/assets/css']);

// watch for changes
const watcher = () => watch('./resources/scss/v4/*.scss', scss());

module.exports = {
  scss,
  watch: watcher,
  default: series(clean, parallel(scripts, scss), js, css)
};
