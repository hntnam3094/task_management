<template>
  <div class="form-wrap">
    <h1 class="header-form">{{ isEdit ? 'Edit Store' : 'Add Store' }}</h1>

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
