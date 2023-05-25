<template>
  <div class="form-group-app">
    <div class="row">
      <div class="col-3">
        Name
      </div>
      <div class="col-9">
        <b-form-input v-model="dataForm.name" placeholder="Enter your blog name" lazy></b-form-input>
        <errorr :errors="errors.name"/>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
        Slug
      </div>
      <div class="col-9">
        <b-form-input v-model="dataForm.slug" placeholder="Enter your blog name"></b-form-input>
        <errorr :errors="errors.slug"/>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
        Description
      </div>
      <div class="col-9">
        <b-form-textarea
          id="textarea"
          v-model="dataForm.description"
          placeholder="Enter something..."
          rows="3"
          max-rows="6"
        ></b-form-textarea>
        <errorr :errors="errors.description"/>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
        Status
      </div>
      <div class="col-9">
        <b-form-checkbox v-model="dataForm.status" switch value="1" unchecked-value="0"></b-form-checkbox>
      </div>
    </div>
    <div class="row">
      <div class="col-3" style="align-self: unset">
        Content
      </div>
      <div class="col-9">
        <VueEditor v-model="dataForm.content"></VueEditor>
        <errorr :errors="errors.content"/>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
      </div>
      <div class="col-6 text-center">
        <button class="btn btn-success btn-sm m-2" @click="save">Save</button>
        <a class="btn btn-danger btn-sm m-2" href="/blog" >Back</a>
      </div>
    </div>
  </div>
</template>

<script>
import BaseForm from "../common/BaseForm";
import Errorr from "../common/errorr";
import { VueEditor } from "vue2-editor";
import Base from "../../mixins/Base";
import {EventBus} from "../app/EventBus";
export default {
  name: "BlogForm",
  mixins: [Base],
  components: {
    Errorr,
    BaseForm,
    VueEditor
  },
  data () {
    return {
      dataForm: {
        userId: '',
        name: '',
        slug: '',
        description: '',
        content: '',
        status: 0
      },
      errors: {}
    }
  },
  computed: {
    isEdit () {
      if (this.$route.params && this.$route.params.id) {
        return true
      }
      return false
    }
  },
  watch: {
    'dataForm.name' (value) {
      if (!this.dataForm.slug) {
        this.dataForm.slug = this.convertToSlug(value)
      }
    }
  },
  mounted() {
    this.dataForm.userId = this.getUserData.id
    if (this.isEdit) {
      this.loadDataForm()
    }
  },
  methods: {
    convertToSlug(text) {
      return text
        .toLowerCase()
        .replace(/ /g,'-')        // Thay thế khoảng trắng bằng dấu gạch ngang
        .replace(/[^\w-]+/g,'')   // Xóa ký tự không hợp lệ
        .replace(/--+/g,'-');     // Xóa những dấu gạch ngang liên tiếp
    },
    loadDataForm () {
      this.$api.get('/blog/'+this.$route.params.id)
        .then(res => {
          this.dataForm = res.data
        }).catch(rej => {
        console.log(rej)
      })
    },
    back () {
      this.$router.push('/blog')
    },
    save () {
      if (!this.isEdit) {
        this.loadingSave = true
        this.$api.post('/blog', this.dataForm)
          .then(response => {
            this.back()
            this.loadingSave = false
          })
          .catch(rej => {
            this.errors = rej.errors
            this.loadingSave = false
          })
      } else {
        this.loadingSave = true
        this.$api.put('/blog/' + this.dataForm.id, this.dataForm)
          .then(response => {
            this.back()
            this.loadingSave = false
          })
          .catch(rej => {
            this.errors = rej.errors
            this.loadingSave = false
          })
      }

    }
  }
}
</script>

<style scoped>

</style>
