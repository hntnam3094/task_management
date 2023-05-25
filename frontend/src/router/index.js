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
      path: '/verify',
      name: 'verify',
      component: () => import('../components/Auth/Verify')
    },
    {
      path: '/login',
      name: 'Login',
      component: () => import('../components/Auth/Login'),
      meta: {
        login: true
      }
    },
    {
      path: '/register',
      name: 'Register',
      component: () => import('../components/Auth/Register'),
    },
    {
      path: '/re-verify',
      name: 'ReVerify',
      component: () => import('../components/Auth/ReVerify'),
    },
    {
      path: '/forget-password',
      name: 'ForgetPassword',
      component: () => import('../components/Auth/ForgetPassword'),
    },
    {
      path: '/setup-password',
      name: 'SetupPassword',
      component: () => import('../components/Auth/SetupPassword'),
    },
    {
      path: '/task',
      name: 'Task',
      component: () => import('../components/Task/TaskList'),
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

  if (!to.meta) {
    next()
  }

  if (to.matched.some(record => record.meta.login)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (isLogged) {
      next({
        path: '/',
        query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next() // make sure to always call next()!
  }

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
