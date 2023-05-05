'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  NODE_ENV: '"development"',
  BASE_URL: '"http://dev.vand.com/"',
  BASE_URL_API: '"http://dev.vand.com/api/"'
})
