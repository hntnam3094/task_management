<template>
  <div class="form-wrap">
    <h1 class="header-form">{{ isEdit ? 'Edit Store' : 'Add Store' }}</h1>
    <div class="container mt-5 form-group-app">
      <div class="row">
        <div class="col-3">
          Name
        </div>
        <div class="col-6">
          <b-form-input v-model="dataForm.name" placeholder="Enter your store name"></b-form-input>
          <errorr :errors="errors.name" />
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          Description
        </div>
        <div class="col-6">
          <b-form-input v-model="dataForm.description" placeholder="Enter your store description"></b-form-input>
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
          <img v-if="file == null && dataForm.image != ''" class="imageCustom" :src="getImageUrl(dataForm.image)" onerror="this.onerror=null;this.src='https://www.energyfit.com.mk/wp-content/plugins/ap_background/images/default/default_large.png';" >
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          Address
        </div>
        <div class="col-6">
          <b-form-textarea
            id="textarea"
            v-model="dataForm.address"
            placeholder="Enter your store address"
            rows="3"
            max-rows="6"
          ></b-form-textarea>
          <errorr :errors="errors.address" />
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          Phone number
        </div>
        <div class="col-6">
          <b-form-input v-model="dataForm.phoneNumber" placeholder="Enter your store phone number"></b-form-input>
          <errorr :errors="errors.phoneNumber" />
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
  name: "StoreFrom",
  mixins: [Auth, Base],
  components: {Errorr},
  data () {
    return {
      dataForm: {
        name: '',
        description: '',
        image: '',
        address: '',
        phoneNumber: ''
      },
      file: null,
      errors: {}
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
    if (this.isEdit) {
      this.loadDataForm()
    }
  },
  methods: {
    loadDataForm () {
      this.$api.get('/get_store_detail/'+this.$attrs.params.id)
        .then(res => {
          this.dataForm = res.data
        }).catch(rej => {
        console.log(rej)
      })
    },
    save () {
      let url = '/create_store'
      if (this.isEdit) {
        url = '/edit_store/' + this.$attrs.params.id
      }
      const formData = new FormData()
      formData.append('name', this.dataForm.name)
      formData.append('description', this.dataForm.description)
      formData.append('address', this.dataForm.address)
      formData.append('phoneNumber', this.dataForm.phoneNumber)
      formData.append('image', this.file)
      formData.append('userId', this.userData.id)
      this.$api.post(url, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
        .then(response => {
          EventBus.$emit('reloadStore')
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
