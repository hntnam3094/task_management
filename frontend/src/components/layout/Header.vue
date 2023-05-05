<template>
  <div>
    <b-navbar toggleable="lg" type="light" variant="faded" class="bg-color-new text-white">
      <div class="container">
        <b-navbar-brand tag="h1" class="mb-0">Management Application</b-navbar-brand>
        <b-navbar-nav>
          <b-nav-item href="/store">
            <i class="bi bi-shop"></i> Store
          </b-nav-item>
          <b-nav-item href="/product">
            <i class="bi bi-box-seam-fill"></i> Product
          </b-nav-item>
          <b-nav-item-dropdown right>
            <template #button-content>
              User
            </template>
            <b-dropdown-item href="/login">Login</b-dropdown-item>
            <b-dropdown-item href="#"><i class="bi bi-person-circle"></i> Profile</b-dropdown-item>
            <b-dropdown-item href="#"><i class="bi bi-door-open-fill"></i> Sign Out</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </div>
    </b-navbar>
  </div>
</template>

<script>
export default {
  name: "header"
}
</script>

<style scoped>
.bg-color-new {
  background-color: #ccc;
}
.nav-item {
  list-style: none;
}
</style>
