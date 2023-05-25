<template>
  <div class="wrap-login">
    <h1 class="title-login">CHANGE PASSWORD</h1>
    <div v-if="message" style="font-size: 15px; color: red">
      {{message}}
    </div>
    <b-form-group id="input-group-2" label="Password:" label-for="input-2" class="form-group">
      <b-form-input
        id="input-2"
        v-model="form.password"
        placeholder="Enter password"
        required
        type="password"
      ></b-form-input>
      <errorr :errors="errors.password"/>
    </b-form-group>

    <b-form-group id="input-group-2" label="Password confirmation:" label-for="input-2" class="form-group">
      <b-form-input
        id="input-2"
        v-model="form.password_confirmation"
        placeholder="Enter password confirmation"
        required
        type="password"
      ></b-form-input>
      <errorr :errors="errors.password_confirmation"/>
    </b-form-group>

    <div class="btn-group-login mb-5">
      <b-button @click="register" :disabled="loading" class="btn-login" type="submit" variant="success m-2">Change password</b-button>.
      <div>
        <router-link to="/login">Back to login</router-link> <br>
      </div>
    </div>
    <v-dialog />
  </div>
</template>

<script>
import errorr from "../common/errorr";
import Auth from "../../mixins/Auth";
import accountSample from "../accountSample";
export default {
  name: 'SetupPassword',
  mixins: [Auth],
  components: {
    errorr
  },
  data() {
    return {
      form: {
        email: '',
        password: '',
        password_confirmation: ''
      },
      errors: {},
      loading: false,
      message: ''
    }
  },
  mounted() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let email = urlParams.get('email')
    if (!email) {
      this.$router.push('/login')
    }
    this.form.email = email
  },
  methods: {
    register () {
      this.loading = true
      this.$api.post('change-password', this.form)
        .then(res => {
          this.$modal.show('dialog', {
            title: 'Congratulations, you have successfully re-verify an account',
            text: 'Please check your email to confirm your email before logging in to the app',
            buttons: [
              {
                title: 'Close',
                handler: () => {
                  this.$modal.hide('dialog')
                  this.$router.push('/login')
                }
              }
            ]
          })
          this.loading = false
        }).catch(rej => {
        this.loading = false
        if (rej.errors) {
          this.errors = rej.errors
        }
        if (rej.message) {
          this.message = rej.message
        }
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
