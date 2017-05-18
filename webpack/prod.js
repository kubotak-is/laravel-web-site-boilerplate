"use strict";

const webpack = require('webpack');
const path = require('path');
const webpackMerge = require('webpack-merge');
const commonConfig = require('./common');

module.exports = webpackMerge(commonConfig, {
    output: {
        filename: "[name].[chunkhash].js"
    },
    plugins: [
        new webpack.DefinePlugin({
            'process.env.NODE_ENV': JSON.stringify('production')
        }),
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: true,
                screw_ie8: true
            }
        }),
        new webpack.optimize.AggressiveMergingPlugin()
    ]
});
