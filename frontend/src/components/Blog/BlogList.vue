<template>
  <div class="container">
    <div class="d-flex justify-content-between">
      <h1>Blog</h1>
      <a class="btn btn-primary" style="height: 40px" href="/blog/add" >Add new</a>
    </div>
    <div v-if="items && items.length > 0" class="blogList">
      <div v-for="(item, index) in items" :key="index" class="blogItem">
        <div class="row">
          <div class="col-10">
            <div class="blogItem--body">
              <router-link :to="`/blog/detail/${item.id}`" class="blogItem--body_title">
               {{ item.name }}
              </router-link>
              <div class="blogItem--body_desc">
                {{ item.description }}
              </div>
            </div>
            <div class="blogItem--footer">
              <div class="row">
                <div class="col-1">
                  <i class="bi bi-eye"></i> {{ item.view }}
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
          <div class="col-2" style="align-self: center">
            <div>
              <a class="btn btn-warning btn-sm" variant="warning" :href="`/blog/edit/${item.id}`"><i class="bi bi-pencil-square"></i></a>
              <b-button class="btn-sm" variant="danger" @click="deleteForm(item.id)"><i class="bi bi-trash-fill"></i></b-button>
            </div>
            <div v-if="item.status == 0" class="text-danger">Hiding</div>
            <div v-if="item.status == 1" class="text-success">Showing</div>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="blogList">
      You dont have any blogs! Create it
    </div>
  </div>
</template>

<script>
import Base from "../../mixins/Base";
import BlogForm from "./BlogForm";
import BlogDetail from "./BlogDetail";
import {EventBus} from "../app/EventBus";
export default {
  name: "BlogList",
  mixins: [Base],
  data () {
    return {
      items: [],
      formAdd: BlogForm,
      formEdit: BlogForm,
      formDetail: BlogForm
    }
  },
  created() {
    EventBus.$on('reloadData', this.loadDataTable)
  },
  destroyed() {
    EventBus.$off('reloadData', this.loadDataTable)
  },
  mounted() {
    this.loadDataTable()
  },
  methods: {
    loadDataTable () {
      this.$api.get('blog')
        .then(res => {
          this.items = res.data
        }).catch(rej => {
        console.log(rej)
      })
    },
    deleteAction(id) {
      this.$api.delete('blog/' + id)
        .then(res => {
          this.loadDataTable()
          this.$modal.hide('dialog')
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
</style>
