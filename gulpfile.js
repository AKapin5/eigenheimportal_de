const {src, dest, series, watch} = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const concat = require('gulp-concat');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const plumber = require('gulp-plumber');
const uglify = require('gulp-uglify-es').default;
const minifyCSS = require('gulp-minify-css');

const scss = () => {
    return src('resources/scss/*.scss')
        .pipe(sourcemaps.init())
        .pipe(plumber())
        .pipe(sass({
            outputStyle: 'expanded'
        }).on('error', sass.logError))
        .pipe(autoprefixer(['last 10 versions', '> 1%', 'ie 9', 'ie 10'], { cascade: true }))
        .pipe(concat('style.min.css'))
        .pipe(minifyCSS())
        .pipe(sourcemaps.write('.'))
        .pipe(dest('public/css'));
};

const js = () => {
    return src(['resources/js/*.js'])
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(concat('custom.min.js'))
        .pipe(sourcemaps.write())
        .pipe(dest('public/js'));
};

const libsJS = () => {
    return src([
        'resources/libs/**/*.js'
    ])
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(concat('libs.min.js'))
        .pipe(sourcemaps.write())
        .pipe(dest('public/js'));
};

const libsCSS = () => {
    return src(['resources/libs/**/*.css'])
        .pipe(sourcemaps.init())
        .pipe(cleanCSS())
        .pipe(concat('libs.css'))
        .pipe(sourcemaps.write())
        .pipe(dest('public/css'));
};

const serve = () => {
    watch('resources/**/*.scss', series(scss));
    watch('resources/**/*.js', series(js));

};

exports.build = series(scss, js, libsJS, libsCSS);
exports.default = exports.build;

exports.serve = series(scss, js, libsJS, libsCSS, serve);
