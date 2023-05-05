import Vue from 'vue'
import Router from 'vue-router'
import store from "../store";
Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: () => import('../components/Home'),
      meta: {
        auth: false
      }
    },
    {
      path: '/login',
      name: 'Login',
      component: () => import('../components/Login'),
      meta: {
        auth: false
      }
    },
    {
      path: '/store',
      name: 'Store',
      component: () => import('../components/store/StoreList'),
      meta: {
        auth: true
      }
    },
    {
      path: '/product',
      name: 'Product',
      component: () => import('../components/product/ProductList'),
      meta: {
        auth: true
      }
    },
    {
      path: "*",
      component: () => import('../components/common/404') }
  ]
})

router.beforeEach((to, from, next) => {
  store.dispatch('beforeStoreIsLogged')
  store.dispatch('beforeStoreUserData')
  if (to.matched.some(record => record.meta.auth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!store.state.storeIsLogged) {
      next({
        path: '/login',
        query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next() // make sure to always call next()!
  }
})

export default router
