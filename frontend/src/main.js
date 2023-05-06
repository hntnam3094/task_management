// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import 'bootstrap-icons/font/bootstrap-icons.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import './assets/css/styel.css'
import vmodal from 'vue-js-modal'

import http from "./axios";
import store from './store'
Vue.use(vmodal)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

Vue.use({
  install(Vue) {
    Vue.prototype.$api = http
  }
})

Vue.config.productionTip = false
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  created() {
    // store.dispatch('initStoreStateBeforeCreate')
  },
  components: { App },
  template: '<App/>'
})
