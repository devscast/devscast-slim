const { series, task, src, dest, watch, parallel } = require('gulp')
const concat = require('gulp-concat')
const minifyCSS = require('gulp-csso')
const gulpSass = require('gulp-sass')
const del = require('del')

// Move JS Files to ./src/js
function js() {
    return src([
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        './src/js/default-assets/active.js'
    ]).pipe(dest("./public/assets/js"))
}

// Combine All js files into one
function scripts() {
    return src([
            'node_modules/owl.carousel2/dist/owl.carousel.min.js',
            './resources/js/mediaelement-and-player.min.js',
            './resources/js/app.js'
        ], { sourcemaps: true })
        .pipe(concat('app.js'))
        .pipe(dest('./public/assets/', { sourcemaps: "." }))
}

// Move CSS and SCSS to ./dist/css
function scss() {
    return src('./resources/scss/app.scss', { sourcemaps: true })
        .pipe(gulpSass())
        .pipe(minifyCSS())
        .pipe(dest('./public/assets/', { sourcemaps: "." }))
}

// clean the dist directory
function clean() {
    return del('./public/assets')
}

// watch for changes
function watcher() {
    return watch('./resources/scss/*.scss', scss())
}

module.exports = {
    scss,
    watch: watcher,
    default: series(clean, parallel(js), parallel(scripts, scss))
}