<template>
  <div class="store">
    <div class="row">
      <div class="col-12 d-flex justify-content-between align-items-center mb-5">
        <div>
          <h1><i class="bi bi-shop"></i> Store management</h1>
          <b-breadcrumb :items="breadcrumb"></b-breadcrumb>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-4">
            <img class="card-img-top imageCustom" :src="getImageUrl(dataForm.image)"  onerror="this.onerror=null;this.src='https://www.energyfit.com.mk/wp-content/plugins/ap_background/images/default/default_large.png';" />
          </div>
          <div class="col-8 form-group-app">
            <div class="row">
              <div class="col-3">
                Name
              </div>
              <div class="col-6">
                {{ dataForm.name }}
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                Description
              </div>
              <div class="col-6">
                {{ dataForm.description }}
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                Address
              </div>
              <div class="col-6">
                {{ dataForm.address }}
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                Phone number
              </div>
              <div class="col-6">
                {{ dataForm.phoneNumber }}
              </div>
            </div>
            <div class="row">
              <div class="col-3">
              </div>
              <div class="col-6">
                <b-button class="btn-sm" variant="warning" @click="openFormEdit(dataForm.id)"><i class="bi bi-pencil-square"></i></b-button>
              </div>
            </div>
          </div>
        </div>

        <product-list :store-id="$route.params.id" />
      </div>
    </div>
  </div>
</template>

<script>
import Base from '../../mixins/Base'
import Auth from "../../mixins/Auth";
import StoreFrom from "./StoreFrom";
import ProductList from "../product/ProductList";
import {EventBus} from "../app/EventBus";
export default {
  name: "StoreDetail",
  mixins: [Base, Auth],
  components: {
    ProductList
  },
  data () {
    return {
      formEdit: StoreFrom,
      dataForm: {
        id: '',
        name: '',
        description: '',
        image: '',
        address: '',
        phoneNumber: ''
      },
      breadcrumb: [
        {
          text: 'Home',
          href: '/'
        },
        {
          text: 'Store management',
          href: '/store'
        },
        {
          text: 'Store detail'
        }
      ],
    }
  },
  created() {
    EventBus.$on('reloadStore', () => {
      this.loadDataForm()
    })
  },
  destroyed() {
    EventBus.$off('reloadStore')
  },
  mounted() {
    this.loadDataForm()
  },
  methods: {
    loadDataForm () {
      this.$api.get('/get_store_detail/'+this.$route.params.id)
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

</style>
