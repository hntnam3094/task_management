<template>
  <div class="form-group-app">
    <div class="row border-bottom mb-5">
      <h1>{{ dataForm.name }}</h1>
      <div class="col-2">
        Created at: {{ dateTimeFormat(dataForm.created_at) }}
      </div>
      <div class="col-2">
       {{ readingTime(dataForm.content) }} minutes to read
      </div>
      <div class="col-1">
        <i class="bi bi-eye"></i> {{ dataForm.view }}
      </div>
    </div>
    <div v-html="dataForm.content" class="editor">
    </div>
    <div class="row">
      <div class="col-3">
      </div>
      <div class="col-6 text-center">
        <button class="btn btn-success btn-sm m-2" @click="edit">Edit</button>
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
  name: "BlogDetail",
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
  mounted() {
    this.loadDataForm()
  },
  methods: {
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
    edit () {
      this.$router.push('/blog/edit/' + this.$route.params.id)
    }
  }
}
</script>

<style scoped>

</style>
