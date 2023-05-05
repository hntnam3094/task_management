<template>
  <h1>Product form</h1>
</template>

<script>
export default {
  name: "ProductForm",
  computed: {
    isEdit () {
      if (this.$attrs.params && this.$attrs.params.id) {
        return true
      }
      return false
    }
  }
}
</script>

<style scoped>

</style>
