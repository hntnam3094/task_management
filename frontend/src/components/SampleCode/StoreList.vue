<template>
  <div class="store">
    <div class="row">
      <div class="col-12 d-flex justify-content-between align-items-center mb-5">
        <div>
          <h1><i class="bi bi-shop"></i> Store management</h1>
          <b-breadcrumb :items="breadcrumb"></b-breadcrumb>
        </div>

      </div>

      <div class="search">
        <div class="form-group">
          <input type="text" class="form-control" v-model="search" placeholder="Search by name" width="200px">
        </div>
        <b-button class="btn-sm" variant="primary" style="height: 30px" @click="openFormAdd"><i class="bi bi-plus-lg"></i> Add new</b-button>
      </div>

      <div v-if="!loading" class="col-12 row mt-5">
        <div v-for="(item, key) in items" :key="key" class="col-3 mb-2">
          <b-card
            tag="article"
            style="max-width: 20rem;"
            class="mb-2"
          >
            <img class="card-img-top" :src="getImageUrl(item.image)" onerror="this.onerror=null;this.src='https://www.energyfit.com.mk/wp-content/plugins/ap_background/images/default/default_large.png';" />
            <b-card-title class="text-eslip">
              {{ item.name }}
            </b-card-title>
            <b-card-text class="text-eslip">
              {{ item.description }}
            </b-card-text>
            <b-card-text class="text-eslip">
              <i class="bi bi-geo-alt-fill"></i> {{ item.address }}
            </b-card-text>
            <b-card-text class="text-eslip">
              <i class="bi bi-telephone-fill"></i> {{ item.phoneNumber }}
            </b-card-text>

            <div class="group-button">
              <b-button class="btn-sm" variant="success" :to="`/store/detail/${item.id}`"><i class="bi bi-search"></i></b-button>
              <b-button class="btn-sm" variant="warning" @click="openFormEdit(item.id)"><i class="bi bi-pencil-square"></i></b-button>
              <b-button class="btn-sm" variant="danger" @click="deleteForm(item.id)"><i class="bi bi-trash-fill"></i></b-button>
            </div>
          </b-card>
        </div>

        <nav aria-label="Page navigation">
          <ul class="pagination">
            <li class="page-item">
              <a class="page-link" @click.prevent="loadData(`/get_store/${userData.id}?page=1`)"><i class="bi bi-chevron-compact-left"></i></a>
            </li>
            <li class="page-item" v-for="page in pages" :key="page" :class="{ active: page == pagination.current_page }">
              <a class="page-link" @click.prevent="loadData(`/get_store/${userData.id}?page=${page}`)">{{ page }}</a>
            </li>
            <li class="page-item">
              <a class="page-link" @click.prevent="loadData(`/get_store/${userData.id}?page=${pagination.last_page}`)"><i class="bi bi-chevron-compact-right"></i></a>
            </li>
          </ul>
        </nav>
      </div>
      <div v-else class="col-12 mt-5">
        <b-skeleton-table
          :rows="5"
          :columns="4"
          :table-props="{ bordered: true, striped: true }"
        ></b-skeleton-table>
        <b-skeleton-table
          :rows="5"
          :columns="4"
          :table-props="{ bordered: true, striped: true }"
        ></b-skeleton-table>
      </div>
    </div>
  </div>
</template>

<script>
import StoreFrom from "./StoreFrom";
import StoreDetail from "./StoreDetail";
import removeDialog from "../common/removeDialog";
import Base from '../../mixins/Base'
import Auth from "../../mixins/Auth";
import {EventBus} from "../app/EventBus";
export default {
  name: "StoreList",
  mixins: [Base, Auth],
  data () {
    return {
      items: [],
      formAdd: StoreFrom,
      formEdit: StoreFrom,
      formDetail: StoreDetail,
      formDelete: removeDialog,
      breadcrumb: [
        {
          text: 'Home',
          to: '/'
        },
        {
          text: 'Store management'
        }
      ],
      pagination: {},
      pages: [],
      search: '',
      loading: false
    }
  },
  watch: {
    search (value) {
      this.loadData(`/get_store/${this.userData.id}?search=${value}`)
    }
  },
  created() {
    EventBus.$on('reloadStore', () => {
      this.loadData('/get_store/' +this.userData.id)
    })
  },
  mounted() {
    this.loadData('/get_store/' +this.userData.id)
  },
  destroyed() {
    EventBus.$off('reloadStore')
  },
  methods: {
    loadData (url) {
      this.loading = true
      this.$api.get(url)
        .then(response => {
          this.items = response.data.data.data;
          this.pagination = response.data.data;
          this.pages = [];
          for (let i = 1; i <= response.data.data.last_page; i++) {
            this.pages.push(i);
          }
          this.loading = false
        })
        .catch(error => {
          this.loading = false
          console.log(error);
        });
    }
  }
}
</script>

<style scoped>
.group-button {
  float: right;
}
.card-img-top {
  height: 200px;
  object-fit: cover;
  padding-bottom: 10px;
}
</style>
