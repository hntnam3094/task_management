import store from "../store";
export default {
  computed: {
    isLogged () {
      return store.state.storeIsLogged
    },
    userData () {
      return store.state.storeUserData
    }
  },
  methods: {
    checkToken (res) {
      localStorage.setItem('isLogged', true)
      localStorage.setItem('token', res.data.token)
      localStorage.setItem('user', JSON.stringify(res.data.user))
      store.dispatch('setIsLogged', true)
      store.dispatch('setUserData', res.data.user)
    },
    resetToken () {
      localStorage.setItem('isLogged', false)
      localStorage.setItem('token', '')
      localStorage.setItem('user', '')
      store.dispatch('setIsLogged', false)
      store.dispatch('setUserData', {})
      this.$router.push('/login')
    }
  }
}
