<template>
  <div class="wrap-login">
    <h1 class="title-login">LOGIN</h1>
    <b-form-group
      id="input-group-1"
      label="Email address:"
      label-for="input-1"
      class="form-group"
    >
      <b-form-input
        id="input-1"
        v-model="form.email"
        type="email"
        placeholder="Enter email"
        required
      ></b-form-input>
      <errorr :errors="this.errors.email"/>
    </b-form-group>

    <b-form-group id="input-group-2" label="Password:" label-for="input-2" class="form-group">
      <b-form-input
        id="input-2"
        v-model="form.password"
        placeholder="Enter name"
        required
      ></b-form-input>
      <errorr :errors="this.errors.password"/>
    </b-form-group>

    <div class="btn-group-login">
      <b-button @click="login" class="btn-login" type="submit" variant="primary mr-2">Login</b-button>
    </div>
    <a></a>
  </div>
</template>

<script>
import errorr from "./common/errorr";
import Auth from "../mixins/Auth";
export default {
  name: 'Login',
  mixins: [Auth],
  components: {
    errorr
  },
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      errors: {}
    }
  },
  methods: {
    login () {
      this.$api.post('login', {email: this.form.email, password: this.form.password})
        .then(res => {
          this.checkToken(res)
          this.$router.push('/')
        }).catch(rej => {
          this.errors = rej.errors
          console.log(rej)
      })
    }
  }
}
</script>

<style>
.title-login {
  font-size: 35px;
  text-align: center;
}
.btn-group-login {
  text-align: center;
  margin-top: 10px;
}
.btn-login {
  width: 300px;
}
.wrap-login {
  width: 500px;
  height: 90%;
  border: 1px solid rgb(204, 204, 204);
  border-radius: 10px;
  padding: 20px 20px 200px;
  margin: 0 auto;
}
.form-group {
  margin-bottom: 10px;
}
</style>
