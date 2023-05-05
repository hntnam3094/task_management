<template>
  <div>
    <h1>Home</h1>
  </div>
</template>

<script>
import testModal from './testModal'
import store from "../store";
export default {
  name: "Home",
  methods: {
    showModal () {
      this.$modal.show(testModal);
    }
  }
}
</script>

<style scoped>

</style>
