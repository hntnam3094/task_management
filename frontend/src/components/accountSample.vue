<template>
  <div class="form-wrap">
    <h1 class="header-form">Account sample</h1>
    <div class="row bg-info">
      <div class="col-1 text-center">
        STT
      </div>
      <div class="col-6 text-center">
        Account
      </div>
      <div class="col-5 text-center">
        Password
      </div>
    </div>
    <div v-for="(user, key) in listUser" :key="key" class="row">
      <div class="col-1 text-center">
        {{ key+1 }}
      </div>
      <div class="col-6 text-center">
        {{ user.email }}
      </div>
      <div class="col-5 text-center">
        password
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "accountSample",
  data () {
    return {
      listUser: []
    }
  },
  mounted() {
    this.getListUser()
  },
  methods: {
    getListUser () {
      this.$api.get('/user_list')
        .then(res => {
          this.listUser = res.data
        }).catch(rej => {
        console.log(rej)
      })
    }
  }
}
</script>

<style scoped>

</style>
