<template>
  <div class="container">
    <div class="d-flex justify-content-between">
      <h1>Blog</h1>
    </div>
    <div v-if="items && items.length > 0" class="blogList">
      <div v-for="(item, index) in items" :key="index" class="blogItem">
        <div class="blogItem--body">
          <router-link :to="`/blog/${item.slug}`" class="blogItem--body_title">
            {{ item.name }}
          </router-link>
          <div class="blogItem--body_desc">
            {{ item.description }}
          </div>
        </div>
        <div class="blogItem--footer">
          <div class="row">
            <div class="col-2">
              <i class="bi bi-person-circle"></i> {{ item.authorBlog }}
            </div>
            <div class="col-2">
              <i class="bi bi-eye"></i> {{ item.view }} view
            </div>
            <div class="col-3">
              Created at: {{ dateTimeFormat(item.created_at) }}
            </div>
            <div class="col-2">
              {{ readingTime(item.content) }} minutes to read
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="blogList">
      Dont have any blog to read
    </div>
  </div>
</template>

<script>
import Base from "../../mixins/Base";
export default {
  name: "PublicBlogList",
  mixins: [Base],
  data () {
    return {
      items: []
    }
  },
  mounted() {
    this.loadDataTable()
  },
  methods: {
    loadDataTable () {
      this.$api.get('/public/blog')
        .then(res => {
          this.items = res.data
        }).catch(rej => {
        console.log(rej)
      })
    }
  }
}
</script>

<style scoped>
.blogItem--body_title {
  font-size: 30px;
  text-decoration: none;
  color: #333333;
}
.blogItem--body_title:hover {
  color: blue;
}
.blogList {
  margin-top: 20px;
}
.blogItem {
  border-bottom: 1px solid;
  margin-top: 10px;
}
.blogItem--footer {
  font-size: 15px;
  margin-top: 5px;
  margin-bottom: 5px;
}
.blogItem--body_desc {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}
</style>
