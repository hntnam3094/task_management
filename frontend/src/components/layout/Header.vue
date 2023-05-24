<template>
  <div>
    <b-navbar toggleable="lg" type="light" variant="faded" class="bg-color-new text-white">
      <div class="container">
        <b-navbar-brand href="/" tag="h1" class="mb-0">Management Application</b-navbar-brand>
        <b-navbar-nav>
          <b-nav-item v-if="!isLogged" to="/login">
            <i class="bi bi-box-arrow-in-right"></i> Login
          </b-nav-item>
          <b-nav-item v-if="isLogged" to="/store">
            <i class="bi bi-shop"></i> Store
          </b-nav-item>
          <b-nav-item v-if="isLogged" to="/product">
            <i class="bi bi-box-seam-fill"></i> Product
          </b-nav-item>
          <b-nav-item-dropdown v-if="isLogged" right>
            <template #button-content>
              {{ isLogged ? userData.name : `User` }}
            </template>
            <b-dropdown-item  @click="logout"><i class="bi bi-door-open-fill"></i> Sign Out</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </div>
    </b-navbar>
  </div>
</template>

<script>
import Auth from "../../mixins/Auth";
export default {
  name: "header",
  mixins: [Auth],
  methods: {
    logout () {
      this.resetToken()
    }
  }
}
</script>

<style scoped>
.bg-color-new {
  background-color: cadetblue;
  color: #ffffff;
}
.nav-item {
  list-style: none;
}
</style>
