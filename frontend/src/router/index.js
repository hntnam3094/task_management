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
        auth: true
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
      path: '/store/detail/:id',
      name: 'Store detail',
      component: () => import('../components/store/StoreDetail'),
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

router.beforeResolve((to, from, next) => {
  store.dispatch('initBeforRouter')
  let isLogged = store.state.storeIsLogged

  if (to.matched.some(record => record.meta.auth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!isLogged) {
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
