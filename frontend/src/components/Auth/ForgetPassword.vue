<template>
  <div class="wrap-login">
    <h1 class="title-login">FORGET PASSWORD</h1>
    <div v-if="message" style="font-size: 15px; color: red">
      {{message}}
    </div>
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

    <div class="btn-group-login mb-5">
      <b-button @click="register" class="btn-login" type="submit" :disabled="loading" variant="success m-2">Send mail</b-button>.
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
export default {
  name: 'ForgetPassword',
  mixins: [Auth],
  components: {
    errorr
  },
  data() {
    return {
      form: {
        email: ''
      },
      errors: {},
      loading: false,
      message: ''
    }
  },
  methods: {
    register () {
      this.loading = true
      this.$api.post('forget-password', this.form)
        .then(res => {
          this.$modal.show('dialog', {
            title: 'Congratulations, you have successfully send mail forget password',
            text: 'Please check your email to change your password before logging in to the app',
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
