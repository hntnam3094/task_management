<template>
<div v-if="labelError">
  <label class="errorrs">{{ labelError }}</label>
</div>
</template>

<script>
export default {
  name: "errorr",
  props: {
    errors: {
      type: Array,
      defaults: []
    }
  },
  computed: {
    labelError () {
      return this.errors && this.errors[0] ? this.errors[0] : ''
    }
  }
}
</script>

<style scoped>
.errorrs {
  font-size: 14px;
  color: red;
}
</style>
