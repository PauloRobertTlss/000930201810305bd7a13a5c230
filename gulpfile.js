const gulp = require('gulp');
const apidoc = require('gulp-api-doc');


require('laravel-elixir-apidoc');

gulp.task('doc', () => {
    return gulp.src('tests/Feature/*.php')
        .pipe(apidoc())
        .pipe(gulp.dest('documentation'));
});