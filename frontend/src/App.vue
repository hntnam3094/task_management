<template>
  <div id="app">
    <Header/>
    <div class="container" style="padding-top: 50px">
      <router-view/>
    </div>
  </div>
</template>

<script>
import Header from "./components/layout/Header";
export default {
  name: 'App',
  components: {
    Header
  }
}
</script>

<style>
</style>
