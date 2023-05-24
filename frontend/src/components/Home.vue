<template>
  <div id="home" class="container-fluid">
    Home
  </div>
</template>

<script>
import store from "../store";
import TaskList from "./Task/TaskList";
export default {
  name: "Home",
  components: {
    TaskList
  },
  methods: {

  }
}
</script>

<style scoped>
</style>
