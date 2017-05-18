"use strict";

// developでなければprod用を使う
const isProd = process.env.NODE_ENV !== 'develop';

const paths = {
    sass: ['resources/assets/sass/**/*.s?ss'],
    watch: {sass: 'resources/assets/sass/**/*.s?ss'},
    dist: {sass: 'public/css'}
};

exports.default = function* () {
    yield this.start(['sass']);
    yield this.watch(paths.sass, ['sass']);
};

exports.sass = function* () {
    yield this
        .source(paths.watch.sass)
        .sass({
            outputStyle: isProd ? "compressed" : 'nested',
            includePaths: ["sass"],
            sourceMap: !isProd,
            outFile: paths.dist.sass + '/map'
        })
        .target(paths.dist.sass);
};
