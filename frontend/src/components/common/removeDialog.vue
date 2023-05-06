<template>
<div class="form-wrap">
  <h1 class="header-form">Delete item</h1>
  <div class="container">
    <p>Are u really want to delete this item?</p>
    <div class="text-center">
      <button class="btn btn-success btn-sm" @click="deleteItem">Yes</button>
      <button class="btn btn-danger btn-sm" @click="close($attrs.params.id)">No</button>
    </div>
  </div>
</div>
</template>

<script>
import Base from "../../mixins/Base";
import {EventBus} from "../app/EventBus";
export default {
  name: "removeDialog",
  mixins: [Base],
  methods: {
    deleteItem () {
      let url = '/delete_store/'
      if (this.$route.name == 'Product' || this.$route.name == 'Store detail') {
        url = '/delete_product/'
      }
      this.$api.put(url+this.$attrs.params.id)
        .then(res => {
          if (this.$route.name == 'Product' || this.$route.name == 'Store detail') {
            EventBus.$emit('reloadProduct')
          } else {
            EventBus.$emit('reloadStore')
          }
          this.close()
        }).catch(rej => {
        console.log(rej)
      })
    }
  }
}
</script>

<style scoped>

</style>
