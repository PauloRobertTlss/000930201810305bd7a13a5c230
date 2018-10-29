const gulp = require('gulp');
const apidoc = require('gulp-api-doc');
const htmltidy = require('gulp-htmltidy');

require('laravel-elixir-apidoc');

gulp.task('doc', (done) => {
    return gulp.src('project/documentation/api/**/*.php')
        .pipe(apidoc({
                  dest: "build/",
                  template: "documentation/",
                  debug: true
              },done))
        .pipe(gulp.dest('documentation'));
});

gulp.task('html', function() {
  return gulp.src('./documentation/*.html')
        .pipe(htmltidy({doctype: 'html5',
                       hideComments: true,
                       indent: false}))
        .pipe(gulp.dest('build/'));;
});