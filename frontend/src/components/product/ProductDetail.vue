<template>
  <div class="form-wrap">
    <h1 class="header-form">Product detail</h1>
    <div class="container mt-5 form-group-app">
      <div class="row">
        <div class="col-3">
          Name
        </div>
        <div class="col-6">
          {{ dataForm.name }}
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          Description
        </div>
        <div class="col-6">
          {{ dataForm.description }}
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          Image
        </div>
        <div class="col-6">
          <img :src="getImageUrl(dataForm.image)" class="imageCustom" onerror="this.onerror=null;this.src='https://www.energyfit.com.mk/wp-content/plugins/ap_background/images/default/default_large.png';" >
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          Price
        </div>
        <div class="col-6">
          {{ dataForm.price }}
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          Store
        </div>
        <div class="col-6">
          {{ getStoreNameById(dataForm.storeId) }}
        </div>
      </div>
      <div class="row">
        <div class="col-3">
        </div>
        <div class="col-6 text-center">
          <button class="btn btn-success btn-sm m-2" @click="editProduct">Edit</button>
          <button class="btn btn-danger btn-sm m-2" @click="close">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Errorr from "../common/errorr";
import Auth from "../../mixins/Auth";
import Base from "../../mixins/Base";
import {EventBus} from "../app/EventBus";
import ProductForm from "./ProductForm";
export default {
  name: "ProductDetail",
  mixins: [Auth, Base],
  components: {Errorr},
  data () {
    return {
      dataForm: {
        name: '',
        description: '',
        image: '',
        price: '',
        storeId: ''
      },
      file: null,
      errors: {},
      options: [],
      formEdit: ProductForm
    }
  },
  mounted() {
    this.loadDataStore('/get_store_all/' +this.userData.id)
    this.loadDataForm()
  },
  methods: {
    editProduct () {
      this.$modal.hideAll()
      this.openFormEdit(this.$attrs.params.id)
    },
    getStoreNameById (id) {
      if (id) {
        if (this.options && this.options.length > 0) {
          let obj = this.options.find(item => item.id == id)
          if (obj) {
            return obj.name
          }
        }
      }
      return '-'
    },
    loadDataStore (url) {
      this.$api.get(url)
        .then(response => {
          this.options = response.data.data
        })
        .catch(error => {
          console.log(error);
        });
    },
    loadDataForm () {
      this.$api.get('/get_product_detail/'+this.$attrs.params.id)
        .then(res => {
          this.dataForm = res.data.data
        }).catch(rej => {
        console.log(rej)
      })
    }
  }
}
</script>

<style scoped>

</style>
