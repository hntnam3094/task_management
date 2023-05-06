import Vue from 'vue'
import Vuex from 'vuex'
import axios from "../axios";
import {promise} from "ora";
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
    initBeforRouter (context) {
      let dataUser = {}
      let isLogged = false
      let logged = localStorage.getItem('isLogged')
      let user = localStorage.getItem('user')
      if (user != undefined && user !== '') {
        dataUser = JSON.parse(user)
      }
      isLogged = logged != null && logged !== 'false'
      context.commit('checkStoreUserData', dataUser)
      context.commit('checkStoreIsLogged', isLogged)
    },
    initStoreStateBeforeCreate (context) {
      return new Promise((resolve, reject) => {
        axios.get('/check-token')
          .then(response => {
            let dataUser = {}
            let isLogged = false
            if (response.data.code == 200) {
              let logged = localStorage.getItem('isLogged')
              let user = localStorage.getItem('user')
              if (user != undefined && user !== '') {
                dataUser = JSON.parse(user)
              }
              isLogged = logged != null && logged !== 'false'
            }
            context.commit('checkStoreUserData', dataUser)
            context.commit('checkStoreIsLogged', isLogged)
            resolve(response)
          })
          .catch(error => {
            context.commit('checkStoreUserData', {})
            context.commit('checkStoreIsLogged', false)
            reject(error)
          })
      })
    }
  }
})
