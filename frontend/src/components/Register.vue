<template>
  <div class="wrap-login">
    <h1 class="title-login">REGISTER</h1>

    <b-form-group
      id="input-group-name"
      label="Name:"
      label-for="input-name"
      class="form-group"
    >
      <b-form-input
        id="input-name"
        v-model="form.name"
        type="text"
        placeholder="Enter name"
        required
      ></b-form-input>
      <errorr :errors="this.errors.name"/>
    </b-form-group>

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
        placeholder="Enter password"
        required
        type="password"
      ></b-form-input>
      <errorr :errors="this.errors.password"/>
    </b-form-group>

    <b-form-group id="input-group-password" label="Password:" label-for="input-password" class="form-group">
      <b-form-input
        id="input-password"
        v-model="form.password_confirmation"
        placeholder="Enter confirmation password"
        required
        type="password"
      ></b-form-input>
      <errorr :errors="this.errors.password_confirmation"/>
    </b-form-group>

    <div class="btn-group-login mb-5">
      <b-button @click="register" class="btn-login" type="submit" :disabled="loading" variant="success m-2">Register</b-button>.
      <div>
        <router-link to="/login">Back to login</router-link> <br>
      </div>
    </div>
    <v-dialog />
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
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      errors: {},
      loading: false,
    }
  },
  methods: {
    register () {
      this.loading = true
      this.$api.post('register', this.form)
        .then(res => {
          this.$modal.show('dialog', {
            title: 'Congratulations, you have successfully registered an account',
            text: 'Please check your email to confirm your email before logging in to the app',
            buttons: [
              {
                title: 'Close',
                handler: () => {
                  this.$modal.hide('dialog')
                }
              }
            ]
          })
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
