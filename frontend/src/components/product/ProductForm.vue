<template>
  <div class="form-wrap">
    <h1 class="header-form">{{ isEdit ? 'Edit Product' : 'Add Product' }}</h1>
    <div class="container mt-5 form-group-app">
      <div class="row">
        <div class="col-3">
          Name
        </div>
        <div class="col-6">
          <b-form-input v-model="dataForm.name" placeholder="Enter your product name"></b-form-input>
          <errorr :errors="errors.name" />
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          Description
        </div>
        <div class="col-6">
          <b-form-input v-model="dataForm.description" placeholder="Enter your product description"></b-form-input>
          <errorr :errors="errors.description" />
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          Image
        </div>
        <div class="col-6">
          <b-form-file v-model="file" class="mt-3" plain></b-form-file>
          <div v-if="file" class="mt-3">Selected file: {{ file ? file.name : '' }}</div>
          <img v-if="file == null && dataForm.image != ''" :src="getImageUrl(dataForm.image)" class="imageCustom"  onerror="this.onerror=null;this.src='https://www.energyfit.com.mk/wp-content/plugins/ap_background/images/default/default_large.png';" >
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          Price
        </div>
        <div class="col-6">
          <b-form-input type="number" v-model="dataForm.price" placeholder="Enter your prouduct price"></b-form-input>
          <errorr :errors="errors.price" />
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          Store
        </div>
        <div class="col-6">
          <b-form-select v-if="options && options.length > 0" v-model="dataForm.storeId" :options="options"></b-form-select>
          <label v-else class="text-danger">Please create a store before creating a product</label>
          <errorr :errors="errors.storeId" />
        </div>
      </div>
      <div class="row">
        <div class="col-3">
        </div>
        <div class="col-6 text-center">
          <button class="btn btn-success btn-sm m-2" @click="save">Save</button>
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
export default {
  name: "ProductForm",
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
      options: []
    }
  },
  computed: {
    isEdit () {
      if (this.$attrs.params && this.$attrs.params.id) {
        return true
      }
      return false
    }
  },
  mounted() {
    this.loadDataStore('/get_store_all/' +this.userData.id)
    if (this.isEdit) {
      this.loadDataForm()
    }
  },
  methods: {
    loadDataStore (url) {
      this.$api.get(url)
        .then(response => {
          let data = response.data.data
          if (data && data.length > 0) {
            data.forEach(item => {
              this.options.push({
                value: item.id,
                text: item.name
              })
            })
          }
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
    },
    save () {
      let url = '/create_product'
      if (this.isEdit) {
        url = '/edit_product/' + this.$attrs.params.id
      }
      const formData = new FormData()
      formData.append('name', this.dataForm.name)
      formData.append('description', this.dataForm.description)
      formData.append('price', this.dataForm.price)
      formData.append('image', this.file)
      formData.append('storeId', this.dataForm.storeId)
      formData.append('userId',  this.userData.id)
      this.$api.post(url, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
        .then(response => {
          EventBus.$emit('reloadProduct')
          this.close()
        })
        .catch(error => {
          this.errors = error
          console.error(error)
        })
    }
  }
}
</script>

<style scoped>

</style>
