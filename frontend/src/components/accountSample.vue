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
    <div v-if="loading" class="row">
      <b-skeleton-table
        :rows="5"
        :columns="4"
        :table-props="{ bordered: true, striped: true }"
      ></b-skeleton-table>
    </div>
  </div>
</template>

<script>
export default {
  name: "accountSample",
  data () {
    return {
      listUser: [],
      loading: false
    }
  },
  mounted() {
    this.getListUser()
  },
  methods: {
    getListUser () {
      this.loading = true
      this.$api.get('/user_list')
        .then(res => {
          this.listUser = res.data
          this.loading = false
        }).catch(rej => {
        this.loading = false
        console.log(rej)
      })
    }
  }
}
</script>

<style scoped>

</style>
