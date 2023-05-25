<template>
  <div class="row">
    <div class="col-9">
      <div class="row border-bottom mb-5">
        <h1>{{ dataForm.name }}</h1>
        <div class="col-2">
          <i class="bi bi-person-circle"></i> {{ dataForm.authorBlog }}
        </div>
        <div class="col-2">
          <i class="bi bi-eye"></i> {{ dataForm.view }} view
        </div>
        <div class="col-3">
          Created at: {{ dateTimeFormat(dataForm.created_at) }}
        </div>
        <div class="col-2">
          {{ readingTime(dataForm.content) }} minutes to read
        </div>

      </div>
      <div v-html="dataForm.content" class="editor">
      </div>
    </div>
    <div class="col-3">
      <h2>Latest posts</h2>
      <div class="latestBlog">
        <div v-for="(item, index) in items" :key="index" class="latestBlog--Item border-bottom mb-3">
          <a :href="`/blog/${item.slug}`" class="latestBlog--Item-title">{{ item.name }}</a>
          <div class="latestBlog--Item-desc">
            {{ item.description }}
          </div>
          <div class="row mt-2" style="font-size: 13px">
            <div class="col-6">
              <i class="bi bi-person-circle"></i> {{ item.authorBlog }}
            </div>
            <div class="col-6">
              <i class="bi bi-eye"></i> {{ item.view }} view
            </div>
            <div class="col-12">
              Created at: {{ dateTimeFormat(item.created_at) }}
            </div>
            <div class="col-12">
              {{ readingTime(item.content) }} minutes to read
            </div>
          </div>
        </div>
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
  name: "PublicBlogDetail",
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
      items: [],
      errors: {}
    }
  },
  mounted() {
    this.loadDataForm()
    this.loadDataLatest()
  },
  methods: {
    loadDataLatest () {
      this.$api.get('/public/latest-blog')
        .then(res => {
          this.items = res.data
        }).catch(rej => {
        console.log(rej)
      })
    },
    loadDataForm () {
      this.$api.get('/public/blog/'+this.$route.params.slug)
        .then(res => {
          this.dataForm = res.data
        }).catch(rej => {
        console.log(rej)
      })
    }
  }
}
</script>

<style scoped>
.latestBlog--Item-title {
  color: #333333;
  text-decoration: none;
  font-size: 20px;
}

.latestBlog--Item-title:hover {
  color: blue;
}

.latestBlog--Item-desc {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  font-size: 14px;
}
</style>
