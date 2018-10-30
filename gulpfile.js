const gulp = require('gulp');
const apidoc = require('gulp-api-doc');

gulp.task('doc', () => {
    return gulp.src('tests/Feature/*.php')
        .pipe(apidoc())
        .pipe(gulp.dest('documentation'));
});
