"use strict";

// developでなければprod用を使う
const isProd = process.env.NODE_ENV !== 'develop';

let config;

if (isProd) {
    config = require('./webpack/prod');
} else {
    config = require('./webpack/dev');
}

module.exports = config;
