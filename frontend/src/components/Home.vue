<template>
  <div>
    <h1>Home</h1>
  </div>
</template>

<script>
import testModal from './testModal'
export default {
  name: "Home",
  mounted() {

  },
  methods: {
    showModal () {
      this.$modal.show(testModal);
    }
  }
}
</script>

<style scoped>

</style>
