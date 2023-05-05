<template>
<h1>Store Form</h1>
</template>

<script>
export default {
  name: "StoreFrom",
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
