import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  // State là Trạng thái => hay còn gọi là Data (dữ liệu) của KHO chứa (store)
  // Tất cả dữ liệu sẽ được khởi tạo trong thuộc tính `state`
  state: {
    storeIsLogged: false,
    storeUserData: {
      id: '',
      name: '',
      email: ''
    }
  },

  // Getters: là các thuộc tính dùng để các component lấy dữ liệu từ KHO chứa (store) về
  getters: {
  },

  // Mutations: là các thuộc tính dùng để thay đổi giá trị bên trong KHO chứa (store)
  // thay đổi giá trị, nhưng chạy ĐỒNG BỘ (SYNC)
  mutations: {
    checkStoreIsLogged(state, value) {
      state.storeIsLogged = value
    },
    checkStoreUserData(state, value) {
      state.storeUserData.id = value.id || ''
      state.storeUserData.name = value.name || ''
      state.storeUserData.email = value.email || ''
    }
  },

  // Actions: là các hàm (methods) dùng để thực hiện các hành động thay đổi giá trị bên trong KHO chứa (store)
  // tương tự như Mutations, nhưng có thể chạy BẤT ĐỒNG BỘ (ASYNC)
  actions: {
    setIsLogged (context, value) {
      context.commit('checkStoreIsLogged', value)
    },
    setUserData (context, value) {
      context.commit('checkStoreUserData', value)
    },
    beforeStoreIsLogged (context) {
      let logged = localStorage.getItem('isLogged')
      context.commit('checkStoreIsLogged', logged != null && logged !== 'false')
    },
    beforeStoreUserData (context) {
      let user = localStorage.getItem('user')
      if (user != undefined && user !== '') {
        context.commit('checkStoreUserData', JSON.parse(user))
      }
    }
  }
})
