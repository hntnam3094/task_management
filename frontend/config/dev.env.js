'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  NODE_ENV: '"development"',
  BASE_URL: '"http://dev.task_mana.com/"',
  BASE_URL_API: '"http://dev.task_mana.com/api/"'
})
