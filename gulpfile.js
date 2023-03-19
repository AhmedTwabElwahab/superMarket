let gulp        = require('gulp');
let sass        = require('gulp-sass');

// Static Server + watching scss/html files
gulp.task('serve', function() {
    gulp.watch('public/sass/*.scss', gulp.series(sass));
});


gulp.task('sass', function() {
    console.log('dsadasds');
});
