import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: () => import('../components/Home')
    },
    {
      path: '/login',
      name: 'Login',
      component: () => import('../components/Login')
    },
    {
      path: '/store',
      name: 'Store',
      component: () => import('../components/store/StoreList')
    },
    {
      path: '/product',
      name: 'Product',
      component: () => import('../components/product/ProductList')
    },
  ]
})
