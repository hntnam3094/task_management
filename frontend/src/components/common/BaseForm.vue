<template>
<div>
  <div class="form_header">
    <div class="container form_header--row">
      <h2 style="color: white">{{ formName ? formName : 'Form' }}</h2>
      <i class="bi bi-x-lg" style="cursor: pointer" @click="closeModal"></i>
    </div>
  </div>
  <div class="container">
    <slot></slot>
  </div>
</div>
</template>

<script>
export default {
  name: "BaseForm",
  props: {
    formName: {
      type: String,
      defaults: ''
    }
  },
  data () {
    return {

    }
  },
  methods: {
    closeModal () {
      this.$emit('close')
    }
  }
}
</script>

<style scoped>
.form_header {
  background-color: cadetblue;
}
.form_header--row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
