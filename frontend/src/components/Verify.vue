<template>
  <div class="container" style="text-align: center; margin: 50px 0px">
   <div v-if="!loadingToken">
     <h1 class="text-success">Congratulations! <br/> Email activation successful !!!</h1>
     <router-link to="login" class="btn btn-primary mt-5">Click here to login</router-link>
   </div>
    <div v-else>
      <h1 class="text-danger">Active token...</h1>
    </div>
  </div>
</template>

<script>
export default {
  name: "Verify",
  data () {
    return {
      loadingToken: false
    }
  },
  mounted() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let token = urlParams.get('token')

    if (token) {
      this.loadingToken = true
      this.$api.post('/verifyToken?token=' + token).then(res => {
        this.loadingToken = false
      }).catch(rej => {
        this.loadingToken = false
      })
    }
  }
}
</script>

<style scoped>

</style>
