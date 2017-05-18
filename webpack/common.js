"use strict";

const webpack = require('webpack');
const path = require('path');
const WebpackChunkHash = require("webpack-chunk-hash");
const ManifestPlugin = require('webpack-manifest-plugin');
const jsSourceDirectory = path.resolve(__dirname, "../resources/assets/js");

module.exports = {
    context: jsSourceDirectory,
    // entry名はmanifestファイルのkey名にも利用します
    entry: {
        'index': 'index.js'
    },
    output: {
        path: path.resolve(__dirname, "../public/js"),
        publicPath: "/public/"
    },
    plugins: [
        new WebpackChunkHash(),
        // node_modules以下のものを共通Chunkにまとめる
        new webpack.optimize.CommonsChunkPlugin({
            name: ["vendor"],
            minChunks: function (module) {
                return module.context && module.context.indexOf('node_modules') !== -1;
            }
        }),
        // webpack内部でモジュール解決に利用される関数のみ共通Chunkから別ファイルに抽出
        // （＝共通Chunk以外のコード変更時、共通Chunkの[chunkhash]が変更されないようにする）
        new webpack.optimize.CommonsChunkPlugin({
            name: 'manifest',
            minChunks: Infinity
        }),
        new ManifestPlugin({
            basePath: '/js/'
        })
    ],
    resolve: {
        modules: [
            jsSourceDirectory,
            "node_modules"
        ],
        extensions: [".js"],
        alias: {
            'react': 'inferno-compat',
            'react-dom': 'inferno-compat'
        }
    },
    module: {
        rules: [
            {
                test: /\.js?$/,
                use: ["babel-loader"],
                exclude: /node_modules/
            }
        ]
    }
};
