"use strict";

const webpack = require('webpack');
const path = require('path');
const webpackMerge = require('webpack-merge');
const ManifestPlugin = require('webpack-manifest-plugin');
const commonConfig = require('./common');
require('dotenv').config();

module.exports = webpackMerge(commonConfig, {
    output: {
        filename: "[name].js",
        publicPath: "/js/"
    },
    devtool: '#eval-source-map',
    devServer: {
        host: "0.0.0.0",
        public: process.env.WEBPACK_PUBLIC_HOST + ":8080",
        watchOptions: {
            poll: true
        },
        proxy: {
            "/": "http://" + process.env.WEBPACK_PUBLIC_HOST
        },
        inline: true
    },
    plugins: [
        new ManifestPlugin({
            basePath: '/js/',
            // dev-serverの場合でもmanifestファイルは出力する
            writeToFileEmit: true
        })
    ]
});