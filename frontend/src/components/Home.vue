<template>
  <div id="home" class="container-fluid">
    <public-blog-list></public-blog-list>
  </div>
</template>

<script>
import PublicBlogList from "./Blog/PublicBlogList";
export default {
  name: "Home",
  components: {
    PublicBlogList
  },
  methods: {

  }
}
</script>

<style scoped>
</style>
