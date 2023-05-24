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
      <errorr :errors="errors.email"/>
    </b-form-group>

    <b-form-group id="input-group-2" label="Password:" label-for="input-2" class="form-group">
      <b-form-input
        id="input-2"
        v-model="form.password"
        placeholder="Enter name"
        required
        type="password"
      ></b-form-input>
      <errorr :errors="errors.password"/>
    </b-form-group>

    <div class="btn-group-login mb-5">
      <b-button @click="login" :disabled="loading" class="btn-login" type="submit" variant="success m-2">Login</b-button>.
      <div>
        <router-link to="/register">Register</router-link> <br>
        <router-link to="/forget-password">Forget password</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import errorr from "./common/errorr";
import Auth from "../mixins/Auth";
import accountSample from "./accountSample";
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
      errors: {},
      loading: false
    }
  },
  methods: {
    login () {
      this.loading = true
      this.$api.post('login', this.form)
        .then(res => {
          this.checkToken(res)
          this.$router.push('/')
          this.loading = false
        }).catch(rej => {
          this.errors = rej.errors
          this.loading = false
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
  padding: 20px 20px 0px;
  margin: 0 auto;
}
.form-group {
  margin-bottom: 10px;
}
</style>
