const gulp = require('gulp');
const apidoc = require('gulp-api-doc');


require('laravel-elixir-apidoc');

gulp.task('doc', () => {
    return gulp.src('tests/Feature/*.php')
        .pipe(apidoc())
        .pipe(gulp.dest('documentation'));
});

gulp.task('doc2', function(){
    return gulp.src('tests/Feature/*.php')
        .pipe(apidoc())
        .pipe(gulp.dest('documentation'));
});